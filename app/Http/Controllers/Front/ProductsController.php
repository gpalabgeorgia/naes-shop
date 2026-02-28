<?php

namespace App\Http\Controllers\Front;

use App\Models\Cart;
use App\Models\DeliveryAddress;
use App\Models\OrdersProduct;
use App\Models\ProductsAttribute;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use App\Models\User;
use App\Models\Country;
use App\Models\Order;
use App\Models\Sms;

class ProductsController extends Controller
{
    public function listing(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);
                // If fabric filter is selected
                if(isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }
                // If sleeve filter is selected
                if(isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }
                // If pattern filter is selected
                if(isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }
                // If fit filter is selected
                if(isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }
                // If occasion filter is selected
                if(isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }
            } else {
                abort(404);
            }
        }else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status',1);
                $categoryProducts = $categoryProducts->paginate(12);

                // Product Filters
                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = "listing";
                return view('front.products.listing')->with(compact('categoryDetails','categoryProducts', 'url', 'fabricArray', 'sleeveArray', 'patternArray','fitArray','occasionArray','page_name'));
            } else {
                abort(404);
            }
        }
    }

    public function detail($id) {
        $productDetails = Product::with(['category', 'brand', 'attributes'=>function($query){
            $query->where('status',1);
        }, 'images'])->find($id)->toArray();
        $total_stock = ProductsAttribute::where('product_id',$id)->sum('stock');
        $relatedProducts = Product::where('category_id',$productDetails['category']['id'])->where('id','!=',$id)->limit(3)->inRandomOrder()->get()->toArray();
        return view('front.products.detail')->with(compact('productDetails','total_stock','relatedProducts'));
    }

    public function getProductPrice(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($data['product_id'], $data['size']);
            return $getDiscountedAttrPrice;
        }
    }

    public function addToCart(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();

            // Check Product Stock is available or not
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'],'size'=>$data['size']])->first()->toArray();
            if($getProductStock['stock']<$data['quantity']) {
                $message = "მოთხოვნილი რაოდენობა არ არის მარაგში!";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            // Generate Session Id if not exists
            $session_id = Session::get('session_id');
            if(empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id',$session_id);
            }
            // Check product if already exists in User Cart
            if(Auth::check()) {
                // User is logged in
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'user_id'=>Auth::user()->id])->count();
            }else {
                // User is not logged
                $countProducts = Cart::where(['product_id'=>$data['product_id'],'size'=>$data['size'],'session_id'=>Session::get('session_id')])->count();
            }
            if($countProducts>0) {
                $message = "პროდუქტი უკვე დამატებულია კალათში!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if(Auth::check()) {
                $user_id = Auth::user()->id;
            }else {
                $user_id = 0;
            }

            // Save product in cart
            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->user_id = $user_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->save();

            $message = 'პროდუქტი დაემატა კალათში!';
            session::flash('success_message',$message);
            return redirect('cart');
        }
    }

    public function cart() {
        $userCartItems = Cart::userCartItems();
        return view('front.products.cart')->with(compact('userCartItems'));
    }

    public function updateCartItemQty(Request $request) {
        if($request->ajax()) {
            $data = $request->all();

            // Get Cart Details
            $cartDetails = Cart::find($data['cartid']);

            // Get Available Product Stock
            $availableStock = ProductsAttribute::select('stock')->where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size']])->first()->toArray();

            // Check Stock is available or not
            if($data['qty']>$availableStock['stock']){
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'არჩეული რაოდენობა მიუწვდომელია!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            // Check size Available
            $availableSize = ProductsAttribute::where(['product_id'=>$cartDetails['product_id'],'size'=>$cartDetails['size'],'status'=>1])->count();
            if($availableSize==0) {
                $userCartItems = Cart::userCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'არჩეული ზომა(-ები) მიუწვდომელია!',
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }

            Cart::where('id',$data['cartid'])->update(['quantity'=>$data['qty']]);
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'status'=>true,
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    public function deleteCartItem(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            Cart::where('id', $data['cartid'])->delete();
            $userCartItems = Cart::userCartItems();
            $totalCartItems = totalCartItems();
            return response()->json([
                'totalCartItems'=>$totalCartItems,
                'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
            ]);
        }
    }

    public function applyCoupon(Request $request) {
        if($request->ajax()) {
            $data = $request->all();
            $userCartItems = Cart::userCartItems();
            $couponCount = Coupon::where('coupon_code', $data['code'])->count();
            if($couponCount==0) {
                $userCartItems = Cart::userCartItems();
                $totalCartItems = totalCartItems();
                return response()->json([
                    'status'=>false,
                    'message'=>'შეყვანილი კუპონი არ არის ვალიდური!',
                    'totalCartItems'=>$totalCartItems,
                    'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                ]);
            }else {
                // Check for other coupon conditions

                // Get coupon Details
                $couponDetails = Coupon::where('coupon_code', $data['code'])->first();

                // Check if coupon is Inactive
                if($couponDetails->status == 0) {
                    $message = "კუპონი არ არის აქტიური!";
                }

                // // Check is Coupon Expired
                $expire_date = $couponDetails->expiry_date;
                $current_date = date('Y-m-d');
                if($expire_date<$current_date) {
                    $message = 'კუპონი ვადაგასულია!';
                }
                // Check if coupon is from  selected categories
                // Get all selected categories from coupon
                $catArr = explode(",", $couponDetails->catedories);

                // Get cart items
                $userCartItems = Cart::userCartItems();

                // Check if coupon belongs to logged in user
                // Get all selected users of coupon
                if(!empty($couponDetails->users)) {
                    $usersArr = explode(",", $couponDetails->users);

                    // Get User ID's of all selected users
                    foreach($usersArr as $key => $user) {
                        $getUserID = User::select('id')->where('email', $user)->first()->toArray();
                        $userID[] = $getUserID['id'];
                    }
                }


                // Get Cart Total Amount
                $total_amount = 0;
                foreach($userCartItems as $key => $item) {
                    if(!in_array($item['product']['category_id'], $catArr)) {
                        $message = 'მოცემული კუპონი არ ეკუთვნის არჩეულ პროდუქტს!';
                    }
                    if(!empty($couponDetails->users)) {
                        if(!in_array($item['user_id'], $userID)) {
                            $message = 'მოცემული კუპონი არ არის თქვენი!';
                        }
                    }

                    $attrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                    $total_amount = $total_amount + ($attrPrice['final_price']*$item['quantity']);
                }


                if(isset($message)) {
                    $userCartItems = Cart::userCartItems();
                    $totalCartItems = totalCartItems();
                    return response()->json([
                        'status'=>false,
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                } else {
                    // Check if amount type is Fixed or Percn entage
                    if($couponDetails->amount_type=="Fixed") {
                        $couponAmount = $couponDetails->amount;
                    }else {
                        $couponAmount = $total_amount * ($couponDetails->amount/100);
                    }
                    $grand_total = $total_amount - $couponAmount;
                    // Add Coupon Code & Amount in Session Variables
                    Session::put('couponAmount', $couponAmount);
                    Session::put('couponCode', $data['code']);

                    $message = "კუპონი წარმატებულად იქნა გამოყენებული. თქვენთვის ხელმისაწვდომია ფასდაკლება!";

                    $totalCartItems = totalCartItems();
                    $userCartItems = Cart::userCartItems();
                    return response()->json([
                        'status'=>true,
                        'message'=>$message,
                        'totalCartItems'=>$totalCartItems,
                        'couponAmount' => $couponAmount,
                        'grand_total' => $grand_total,
                        'view'=>(String)View::make('front.products.cart_items')->with(compact('userCartItems'))
                    ]);
                }
            }
        }
    }

    public function checkout(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            if(empty($data['address_id'])) {
                $message = "გთხოვთ აირჩიოთ მიწოდების მისამართი!";
                session::flash('error_message', $message);
                return redirect()->back();
            }
            if(empty($data['payment_gateway'])) {
                $message = "გთხოვთ აირჩიოთ გადახდის მეთოდი!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            if($data['payment_gateway']=="COD") {
                $payment_method = "COD";
            }else {
                echo "Coming soon"; die;
                $payment_method = "Prepaid";
            }
            // Get Delivery address from address_id
            $deliveryAddress = DeliveryAddress::where('id', $data['address_id'])->first()->toArray();

            DB::beginTransaction();

            // Insert Order Details
            $order = new Order;
            $order->user_id = Auth::user()->id;
            $order->name = $deliveryAddress['name'];
            $order->address = $deliveryAddress['address'];
            $order->city = $deliveryAddress['city'];
            $order->state = $deliveryAddress['state'];
            $order->country = $deliveryAddress['country'];
            $order->pincode = $deliveryAddress['pincode'];
            $order->mobile = $deliveryAddress['mobile'];
            $order->email = Auth::user()->email;
            $order->shipping_charges = 0;
            $order->coupon_code = Session::get('couponCode');
            $order->coupon_amount = Session::get('couponAmount');
            $order->order_status = "New";
            $order->payment_method = $payment_method;
            $order->payment_gateway = $data['payment_gateway'];
            $order->grand_total = Session::get('grand_total');
            $order->save();

            // Get las Order Id
            $order_id = DB::getPdo()->lastInsertId();

            // Get User Cart Items
            $cartItems = Cart::where('user_id', Auth::user()->id)->get()->toArray();
            foreach($cartItems as $key => $item) {
                $cartItem = new OrdersProduct;
                $cartItem->order_id = $order_id;
                $cartItem->user_id = Auth::user()->id;

                $getProductDetails = Product::select('product_code', 'product_name', 'product_color')->where('id', $item['product_id'])->first()->toArray();
                $cartItem->product_id = $item['product_id'];
                $cartItem->product_code = $getProductDetails['product_code'];
                $cartItem->product_name = $getProductDetails['product_name'];
                $cartItem->product_color = $getProductDetails['product_color'];
                $cartItem->product_size = $item['size'];
                $getDiscountedAttrPrice = Product::getDiscountedAttrPrice($item['product_id'], $item['size']);
                $cartItem->product_price = $getDiscountedAttrPrice['final_price'];
                $cartItem->product_qty = $item['quantity'];
                $cartItem->save();
            }

            // Insert Order id in Session Variable
            Session::put('order_id', $order_id);

            DB::commit();

            if($data['payment_gateway']=="COD") {

                // Send Order SMS
                $message = "ძვირფასო მომხმარებელო, თქვენი შეკვეთა ".$order_id."მიღებულია. ჩვენ მალე შეგატყობინებთ შეკვეთის გამოგზავნის სტატუსს.";
                $mobile = Auth::user()->mobile;
                Sms::sendSms($message, $mobile);

                $orderDetails = Order::with("orders_products")->where("id", $order_id)->first()->toArray();

                // Send Order Email
                $email = Auth::user()->email;
                $messageData = [
                    "email" => $email,
                    "name" => Auth::user()->name,
                    "order_id" => $order_id,
                    "orderDetails" => $orderDetails
                ];

                Mail::send("emails.order", $messageData, function($message) use($email) {
                    $message->to($email)->subject('შეკვეთა განთავსებულია - NAES SHOP');
                    $message->embed(public_path('images/front_images/logo_email.png'));
                });

                return redirect('/thanks');
            }else {
                echo "გადახდის მეთოდი მალე დაემატება"; die;
            }

            echo "Order Placed"; die;
        }
        $userCartItems = Cart::userCartItems();
        $deliveryAddresses = DeliveryAddress::deliveryAddresses();
        return view('front.products.checkout')->with(compact('userCartItems', 'deliveryAddresses'));
    }

    public function thanks() {
        if(Session::has('order_id')) {
            // Empty the User Cart
            Cart::where('user_id', Auth::user()->id)->delete();
            return view('front.products.thanks');
        }else {
            return redirect('/cart');
        }
    }
    public function addEditDeliveryAddress($id=null, Request $request) {
        if($id=="") {
            // Add Delivery Address
            $title = "მისამართის დამატება";
            $address = new DeliveryAddress;
            $message = "მისამართი წარმატებით დაემატა!";
        }else {
            // Edit Delivery Address
            $title = "მისამართის რედაქტირება";
            $address = DeliveryAddress::find($id);
            $message = "მისამართი წარმატებით გაახლდა!";
        }
        if($request->isMethod('post')) {
            $data = $request->all();
            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'address' => 'required',
                'city' => 'required|regex:/^[\pL\s\-]+$/u',
                'state' => 'required|regex:/^[\pL\s\-]+$/u',
                'country' => 'required',
                'pincode' => 'required|numeric|digits:6',
            ];
            $customMessages = [
                'name.required' => 'სახელი/გვარი სავალდებულოა',
                'name.regex' => 'გთხოვთ შეიყვანოთ ვალიდური სახელი/გვარი',
                'address.required' => 'მისამართის მითითება სავალდებულოა',
                'city.required' => 'ქალაქის მითითება სავალდებულოა',
                'city.regex' => 'გთხოვთ შეიყვანოთ ვალიდური ქალაქი',
                'state.required' => 'რეგიონის მითითება სავალდებულოა',
                'state.regex' => 'გთხოვთ შეიყვანოთ ვალიდური რეგიონი',
                'country.required' => 'ქვეყნის არჩევა სავალდებულოა',
                'pincode.required' => 'პინკოდი სავალდებულოა',
                'pincode.numeric' => 'შეიყვანეთ ვალიდური პინკოდი',
                'pincode.digits' => 'პინკოდი უნდა შედგებოდეს 6 რიცხვიდან',
                'mobile.required' => 'ტელეფონის ნომრის მითითება სავალდებულოა',
//                'mobile.numeric' => 'გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი',
            ];
            $this->validate($request, $rules, $customMessages);

            $address->user_id = Auth::user()->id;
            $address->name = $data['name'];
            $address->address = $data['address'];
            $address->city =$data['city'];
            $address->state = $data['state'];
            $address->country = $data['country'];
            $address->pincode = $data['pincode'];
            $address->mobile = $data['mobile'];
            $address->status = 1;
            $address->save();
            Session::put('success_message',$message);
            return redirect('checkout');
        }
        $countries = Country::where('status', 1)->get()->toArray();
        return view('front.products.add_edit_delivery_address')->with(compact('countries', 'title', 'address'));
    }

    public function deleteDeliveryAddress($id) {
        DeliveryAddress::where('id', $id)->delete();
        $message = "მიწოდების მისამართი წარმატებით წაიშალა!";
        Session::put('success_message', $message);
        return redirect()->back();
    }
}
