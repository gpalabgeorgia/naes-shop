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
                <div class="col-sm-4">
                    <div class="signup-form">
                        <h2>დაგავიწყდათ პაროლი?</h2>
                        შეიყვანეთ თქვენი ელ.ფოსტის მისამართი ახალი პაროლის მისაღებად. <br><br>
                        <form id="forgotPasswordForm" action="{{ url('/forgot-password') }}" method="post">@csrf
                            <input type="email" id="email" name="email" placeholder="ელ.ფოსტა" required=""/>
                            <button type="submit" class="btn btn-default">აღდგენა</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
