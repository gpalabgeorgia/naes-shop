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
                        <h2>შედით თქვენს აქაუნთში</h2>
                        <form id="loginForm" action="{{ url('/login') }}" method="post">@csrf
                            <input type="email" id="email" name="email" placeholder="ელ.ფოსტა" />
                            <input type="password" id="password" name="password" placeholder="პაროლი" />
{{--                            <span>--}}
{{--								<input type="checkbox" class="checkbox">--}}
{{--								დარჩი სისტემაში--}}
{{--							</span>--}}
                            <button type="submit" class="btn btn-default">შესვლა</button>
                            <br>
                            <a href="{{ url('forgot-password') }}">პაროლის აღდგენა</a>
                        </form>
                    </div><!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">ან</h2>
                </div>
                <div class="col-sm-4">
                    <div class="signup-form"><!--sign up form-->
                        <h2>გაიარე რეგისტრაცია!</h2>
                        <form id="registerForm" action="{{ url('/register') }}" method="post">@csrf
                            <input type="text" id="name" name="name" placeholder="სახელი/გვარი"/>
                            <input type="text" id="mobile" name="mobile" placeholder="ტელეფონის ნომერი"/>
                            <input type="email" id="email" name="email" placeholder="ელ.ფოსტა"/>
                            <input type="password" id="password" name="password" placeholder="პაროლი"/>
                            <button type="submit" class="btn btn-default">რეგისტრაცია</button>
                        </form>
                    </div><!--/sign up form-->
                </div>
            </div>
        </div>
    </section><!--/form-->
@endsection
