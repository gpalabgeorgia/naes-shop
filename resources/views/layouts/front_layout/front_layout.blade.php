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
</head><!--/head-->

<body>

@include('layouts.front_layout.front_header')

@include('front.banners.home_page_banners')

<section>
    <div class="container">
        <div class="row">
            @include('layouts.front_layout.front_sidebar')

            @yield('content')
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
