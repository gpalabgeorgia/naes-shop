<?php
    use App\Models\Cart;
    use App\Models\Product;
    $item = Cart::userCartItems();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>NAES-SHOP</title>
    <link href="{{ asset('css/front_css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/front_css/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/all.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/brand.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/regular.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/solid.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/svg.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/svg-with-js.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/v4-font-face.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/v4-shims.css') }}">
    <link rel="stylesheet" href="{{ url('font/fontawesome7/css/v5-font-face.css') }}">
    <style>
        @media (max-width: 768px) {

            .cart_info table thead {
                display: none;
            }

            .cart_info table tr {
                display: block;
                margin-bottom: 20px;
                border-bottom: 1px solid #ddd;
            }

            .cart_info table td {
                display: block;
                text-align: right !important;
                padding: 8px;
                position: relative;
            }

            .cart_info table td::before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
            }
        }
    </style>
</head><!--/head-->
<body>
    @include('layouts.front_layout.front_header')
    <section id="form"><!--form-->
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
            <div class="row justify-content-center">
                <div class="col-12 col-md-5 mb-4">
                    <div class="login-form"><!--login form-->
                        <h2>შედით თქვენს აქაუნთში</h2>
                        <form action="#">
                            <input type="text" placeholder="სახელი" />
                            <input type="email" placeholder="ელ.ფოსტა" />
                            <span>
								<input type="checkbox" class="checkbox">
								დარჩი სისტემაში
							</span>
                            <button type="submit" class="btn btn-default">შესვლა</button>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="d-none d-md-flex col-md-1 justify-content-center align-items-center">
                    <h2 class="or">ან</h2>
                </div>
                <div class="col-12 col-md-5">
                    <div class="signup-form"><!--sign up form-->
                        <h2>რეგისტრაცია!</h2>
                        <form action="#">
                            <input type="text" placeholder="სახელი/გვარი"/>
                            <input type="email" placeholder="ელ.ფოსტა"/>
                            <input type="password" placeholder="პაროლი"/>
                            <button type="submit" class="btn btn-default">რეგისტრაცია</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section>

    <section id="cart_items">
        <div class="container">
            <div class="table-responsive cart_info">
                <div class="table-responsive">
                    <table class="table table-condensed">
                        <thead>
                        <tr class="cart_menu">
                            <th style="text-align: center;" class="image">პროდუქტი</th>
                            <th style="text-align: center;" class="description" colspan="2">აღწერა</th>
                            <th style="text-align: center;" class="quantity">რაოდენობა</th>
                            <th style="text-align: center;" class="price">ფასი ც.</th>
                            <th style="text-align: center;">ფასდაკლება</th>
                            <th style="text-align: center;" class="total">ფასი</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php $total_price = 0; ?>
                            @foreach($userCartItems as $item)
                                    <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']); ?>
                                <tr>
                                    <td style="text-align: center;"> <img width="60" src="{{ asset('images/product_images/large/'.$item['product']['main_image']) }}" alt=""/></td>
                                    <td colspan="2">
                                        {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>
                                        ფერი: {{ $item['product']['product_color'] }} <br>
                                        ზომა: {{ $item['size'] }}
                                    </td>
                                    <td style="text-align: center;">
                                        <div style="display:flex; align-items:center; justify-content:center; gap:5px; flex-wrap:nowrap;">

                                            <button class="btn btnItemUpdate qtyMinus"
                                                    type="button"
                                                    data-cartid="{{ $item['id'] }}"
                                                    style="min-width:35px;">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>

                                            <input type="text"
                                                   value="{{ $item['quantity'] }}"
                                                   readonly
                                                   style="width:60px; text-align:center; height:35px;">

                                            <button class="btn btnItemUpdate qtyPlus"
                                                    type="button"
                                                    data-cartid="{{ $item['id'] }}"
                                                    style="min-width:35px;">
                                                <i class="fa-solid fa-plus"></i>
                                            </button>

                                            <button class="btn btnItemDelete"
                                                    type="button"
                                                    data-cartid="{{ $item['id'] }}"
                                                    style="min-width:35px; background:#FE980F; border:none;">
                                                <i class="fa-solid fa-xmark"></i>
                                            </button>

                                        </div>
                                    </td>
                                    <td style="text-align: center;">{{ $attrPrice['product_price'] }} ₾.</td>
                                    <td style="text-align: center;">{{ $attrPrice['discount'] }} ₾.</td>
                                    <td style="text-align: center;">{{ $attrPrice['final_price'] * $item['quantity'] }} ₾.</td>
                                </tr>
                                    <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
                            @endforeach
                            <tr>
                                <td data-label="ფასი" colspan="6" style="text-align:right">ფასი: </td>
                                <td style="text-align: center;">{{ $total_price }} ₾.</td>
                            </tr>
                            <tr>
                            <td data-label="კუპონით ფასდაკლება" colspan="6" style="text-align:right">კუპონით ფასდაკლება: </td>
                            <td data-label="ფასდაკლება" style="text-align: center;" class="couponAmount">
                                @if(Session::has('CouponAmount'))
                                    - {{ Sesion::get('CouponAmount') }} ₾.
                                @else
                                    0 ₾.
                                @endif
                            </td>
                        </tr>
                            <tr>
                                <td data-label="სულ" colspan="6" style="text-align:right"><strong>სულ ({{ $total_price }} ₾. - <strong class="couponAmount">0 ₾.</strong>) = </strong></td>
                                <td data-label="ჯამი" style="background-color: #FE980F; text-align: center;">{{ $total_price }} ₾.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <div class="text-end mt-3" style="text-align: right;">
                <a class="btn btn-warning w-100 w-md-auto mb-2">გაახლება</a>
                <a class="btn btn-success w-100 w-md-auto">გადახდა</a>
            </div>
            </div>
        </div>
    </section>
    @include('layouts.front_layout.front_footer')
    <script src="{{ asset('js/front_js/jquery.js') }}"></script>
    <script src="{{ asset('js/front_js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/front_js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('js/front_js/price-range.js') }}"></script>
    <script src="{{ asset('js/front_js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('js/front_js/main.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/all.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/brands.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/fontawesome.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/regular.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/solid.js') }}"></script>
    <script src="{{ url('font/fontawesome7/js/v4-shims.js') }}"></script>
    <script src="{{ url('js/front_js/front_script.js') }}"></script>
    </body>
    </html>
