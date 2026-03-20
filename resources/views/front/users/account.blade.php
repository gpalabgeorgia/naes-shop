@extends('layouts.front_layout.front_layout')
@section('content')
    <section id="form"><!--form-->
        <div class="container">
            @if(Session::has('success_message'))
                <div class="alert alert-success" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            @if(Session::has('error_message'))
                <div class="alert alert-danger" role="alert">
                    {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form"><!--login form-->
                        <h2>პაროლის გაახლება</h2>
                        <form id="passwordForm" action="{{ url('/update-user-pwd') }}" method="post">@csrf
                            <input type="password" id="current_pwd" name="current_pwd" placeholder="მიმდინარე პაროლი" />
                            <span id="chkPwd"></span>
                            <input type="password" id="new_pwd" name="new_pwd" placeholder="ახალი პაროლი" />
                            <input type="password" id="confirm_pwd" name="confirm_pwd" placeholder="გაიმეორეთ პაროლი" />
                            <button type="submit" class="btn btn-default">პაროლის გაახლება</button>
                            <br>
{{--                            <a href="{{ url('forgot-password') }}">პაროლის გაახლება</a>--}}
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">ან</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>შეიყვანეთ საკონტაქტო ინფორმაცია</h2>
                        <form id="accountForm" action="{{ url('/account') }}" method="post">@csrf
                            <input type="text" id="name" name="name" placeholder="სახელი/გვარი" value="{{ $userDetails['name'] }}" pattern="[A-Za-z]+"/>
                            <input type="text" id="address" name="address" placeholder="მისამართი" value="{{ $userDetails['address'] }}"/>
                            <input type="text" id="city" name="city" placeholder="ქალაქი" value="{{ $userDetails['city'] }}"/>
                            <input type="text" id="state" name="state" placeholder="რეგიონი" value="{{ $userDetails['state'] }}"/>
                            <select class="span3" style="height: 40px;" name="country" id="country">
                                <option value="">აირჩიეთ ქვეყანა</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country['country_name'] }}" @if($country['country_name']==$userDetails['country']) selected="" @endif>{{ $country['country_name'] }}</option>
                                @endforeach
                            </select><br><br>
                            <input type="text" id="pincode" name="pincode" placeholder="პინკოდი" value="{{ $userDetails['pincode'] }}"/>
                            <input type="text" id="mobile" name="mobile" placeholder="ტელეფონის ნომერი" value="{{ $userDetails['mobile'] }}"/>
                            <input readonly="readonly" value="{{ $userDetails['email'] }}"/>
                            <button type="submit" class="btn btn-default">გაახლება</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection
