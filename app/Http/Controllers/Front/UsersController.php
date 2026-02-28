<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Cart;
use App\Models\Sms;
use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    public function loginRegister() {
        return view('front.users.login_register');
    }

    public function registerUser(Request $request) {
        if($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            // Check if User already exists
            $userCount = User::where('email', $data['email'])->count();
            if($userCount>0) {
                $message = "ელ.ფოსტა უკვე დარეგისტრირებულია!";
                session::flash('error_message', $message);
                return redirect()->back();
            }else {
                // Register the User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 0;
                $user->save();

                // Send Confirmation Email
                $email = $data['email'];
                $messageData = [
                    'email' => $data['email'],
                    'name' => $data['name'],
                    'code' => base64_encode($data['email']),
                ];
                Mail::send('emails.confirmation',$messageData,function($message) use($email) {
                    $message->to($email)->subject('დაადასტურეთ თქვენი რეგისტრაცია NAES მაღაზიაში');
                });

                // Redirect back with Success Message
                $message = "გთხოვთ დაადასტუროთ თქვენს ელ.ფოსტაზე თქვენი აქაუნთის გააქტიურება!";
                Session::put('success_message',$message);
                return redirect()->back();

                // if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
                //     // Update User Cart with user id
                //     if(!empty(Session::get('session_id'))) {
                //         $user_id = Auth::user()->id;
                //         $session_id = Session::get('session_id');
                //         Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                //     }

                //     // Send Register SMS
                //     // $message = "ძვირფასო მომხმარებელო, თქვენ წარმატებით დარეგისგტრირდით ონლაინ მაღაზიაში NAES. გთხოვთ შეხვიდეთ თქვენს აქაუნთში სასურველი პროდუქცის შესაძენად.";
                //     // $mobile = $data['mobile'];
                //     // Sms::sendSms($message, $mobile);

                //     // Send Register Emaii
                //     $email = $data['email'];
                //     $messageData = ['name'=>$data['name'], 'mobile'=>$data['mobile'], 'email'=>$data['email']];
                //     Mail::send('emails.register', $messageData, function($message) use($email) {
                //         $message->to($email)->subject('კეთილი იყოს თქვენი მობრძანება ონლაინ მაღაზიაში NAES');
                //     });
                //         return redirect('/');
                // }
            }
        }
    }

    public function confirmAccount($email) {
        Session::forget('error_message');
        Session::forget('success_message');
        // Decode User Email
        $email = base64_decode($email);

        // Check User Email exists
        $userCount = User::where('email',$email)->count();
        if($userCount>0) {
            // User Email is already activated or not
            $userDetails = User::where('email',$email)->first();
            if($userDetails->status == 1) {
                $message = "თქვენი აქაუნთი გააქტირებულია. შეგიძლიათ შეხვიდეთ მაღაზიაში!";
                Session::put('error_message',$message);
                return redirect('login-register');
            }else {
                // Update User Status to 1 to activated account
                User::where('email',$email)->update(['status'=>1]);

                // Send Register SMS
                // $message = "ძვირფასო მომხმარებელო, თქვენ წარმატებით დარეგისგტრირდით ონლაინ მაღაზიაში NAES. გთხოვთ შეხვიდეთ თქვენს აქაუნთში სასურველი პროდუქცის შესაძენად.";
                // $mobile = $userDetails['mobile'];
                // Sms::sendSms($message, $mobile);

                // Send Register Emaii
                $messageData = ['name'=>$userDetails['name'], 'mobile'=>$userDetails['mobile'], 'email'=>$email];
                Mail::send('emails.register', $messageData, function($message) use($email) {
                    $message->to($email)->subject('კეთილი იყოს თქვენი მობრძანება ონლაინ მაღაზიაში NAES');
                });

                // Redirect to Login/Register page with Success message
                $message = "თქვენი ელ.ფოსტა გააქტიურებულია. შეგიძლიათ შეხვიდეთ მაღაზიაში.";
                Session::put('success_message',$message);
                return redirect('login-register');
            }
        }else {
            abort(404);
        }
    }

    public function checkEmail(Request $request) {
        // Check if email already exists
        $data = $request->all();
        $emailCount = User::where('email', $data['email'])->count();
        if($emailCount>0) {
            return "false";
        }else {
            return "true";
        }
    }

    public function loginUser(Request $request) {
        if($request->isMethod('post')) {
            Session::forget('error_message');
            Session::forget('success_message');
            $data = $request->all();
            if(Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {

                // Check Email is activated or not
                $userStatus = User::where('email', $data['email'])->first();
                if($userStatus->status == 0) {
                    Auth::logout();
                    $message = "თქვენი აქაუნთი არ არის გააქტიურებული! გთხოვთ გააქტიუროთ აქაუნთი ელ.ფოსტაზე მოსულ შეტყობინებაში ბმულზე დაწკაპებით!";
                    Session::put('error_message',$message);
                    return redirect()->back();
                }

                // Update User Cart with user id
                if(!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id',$session_id)->update(['user_id'=>$user_id]);
                }

                return redirect('/cart');
            }else {
                $message = "არასწორი ელ.ფოსტის მისამართი ან პაროლი";
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function logoutUser() {
        Auth::logout();
        return redirect('/');
    }

    public function forgotPassword(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $emailCount = User::where('email', $data['email'])->count();
            if($emailCount==0) {
                $message = 'აღნიშნული ელ.ფოსტა არ მოიძებნა!';
                Session::put('error_message', 'აღნიშნული ელ.ფოსტა არ მოიძებნა!');
                Session::forget('success_message');
                return redirect()->back();
            }

            // Generate new random password
            $random_password = str_random(8);

            // Encode/Secure Password
            $new_password = bcrypt($random_password);

            // Update Password
            User::where('email',$data['email'])->update(['password'=>$new_password]);

            // Get User Name
            $userName = User::select('name')->where('email',$data['email'])->first();

            // Send Forgot Password Email
            $email = $data['email'];
            $name = $userName->name;
            $messageData = [
                'email' => $email,
                'name' => $name,
                'password' => $random_password
            ];
            Mail::send('emails.forgot_password', $messageData, function($message)use($email) {
                $message->to($email)->subject('ახალი პაროლი - ონლაინ მაღაზია NAES');
            });
            // Redirect to Login/Register Page with Success message
            $message = "გთხოვთ შეამოწმოთ ელ.ფოსტა ახალი პაროლის მისაღებად";
            Session::put('success_message', $message);
            Session::forget('error_message');
            return redirect('login-register');
        }
        return view('front.users.forgot_password');
    }

    public function account(Request $request) {
        $user_id = Auth::user()->id;
        $userDetails = User::find($user_id)->toArray();

        $countries = Country::where('status', 1)->get()->toArray();

        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            Session::forget('error_message');
            Session::forget('success_message');

            $rules = [
                'name' => 'required|regex:/^[\pL\s\-]+$/u',
                'mobile' => 'required|numeric',
            ];
            $customMessages = [
                'name.required' => 'სახელი/გვარი სავალდებულოა',
                'name.regex' => 'გთხოვთ შეიყვანოთ ვალიდური სახელი/გვარი',
                'mobile.required' => 'ტელეფონის ნომრის მითითება სავალდებულოა',
                'mobile.numeric' => 'გთხოვთ შეიყვანოთ ვალიდური ტელეფონის ნომერი',
            ];
            $this->validate($request, $rules, $customMessages);

            $user = User::find($user_id);
            $user->name = $data['name'];
            $user->address = $data['address'];

            $user->city =$data['city'];
            $user->state = $data['state'];
            $user->country = $data['country'];
            $user->pincode = $data['pincode'];
            $user->mobile = $data['mobile'];
            $user->save();
            $message = "თქვენი აქაუნთის დეტალები წარმატებით გაახლდა!";
            Session::put('success_message',$message);
            return redirect()->back();
        }

        return view('front.users.account')->with(compact('userDetails', 'countries'));
    }

    public function chkUserPassword(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $user_id = Auth::User()->id;
            $chkPassword = User::select('password')->where('id', $user_id)->first();
            if(Hash::check($data['current_pwd'],$chkPassword->password)) {
                return "true";
            }else {
                return "false";
            }
        }
    }

    public function updateUserPassword(Request $request) {
        if($request->isMethod('post')) {
            $data = $request->all();
            $user_id = Auth::User()->id;
            $chkPassword = User::select('password')->where('id', $user_id)->first();
            if(Hash::check($data['current_pwd'],$chkPassword->password)) {
                // Update Current Password
                $new_pwd = bcrypt($data['new_pwd']);
                User::where('id',$user_id)->update(['password'=>$new_pwd]);
                $message = "პაროლი წარმატებით განახლდა!";
                Session::put('success_message', $message);
                Session::forget('error_message');
                return redirect()->back();
            }else {
                $message = "მიმდინარე პაროლი არასწორია!";
                Session::put('error_message', $message);
                Session::forget('success_message');
                return redirect()->back();
            }
        }
    }
}
