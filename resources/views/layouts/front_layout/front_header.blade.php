<?php
    use App\Models\Sections;
    $sections = Sections::sections();
?>
<header id="header"><!--header-->
    <div class="header_top"><!--header_top-->
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <div class="contactinfo">
                        <ul class="nav nav-pills">
                            <li><a href="#"><i class="fa fa-phone"></i> +34 654 937 836</a></li>
                            <li><a href="#"><i class="fa fa-envelope"></i> info@domain.com</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="social-icons pull-right">
                        <ul class="nav navbar-nav">
                            <li><a target="_blank" href="{{ url('https://www.facebook.com/profile.php?id=61582718488936') }}"><i class="fa-brands fa-facebook-f" style="color: #696763;"></i></a></li>&nbsp;&nbsp;
                            <li><a target="_blank" href="{{ url('https://www.instagram.com/naes_zapato/') }}"><i class="fa-brands fa-square-instagram" style="color: #696763;"></i></a></li>&nbsp;&nbsp;
{{--                            <li><a href="#"><i class="fa-brands fa-linkedin-in" style="color: #696763;"></i></a></li>&nbsp;--}}
{{--                            <li><a href="#"><i class="fa-brands fa-youtube" style="color: #696763;"></i></a></li>&nbsp;--}}
{{--                            <li><a href="#"><i class="fa-brands fa-google-plus-g" style="color: #696763;"></i></a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header_top-->

    <div class="header-middle"><!--header-middle-->
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <div class="logo pull-left">
                        <a href="{{ url('/') }}"><img width="50" src="{{ asset('images/front_images/home/naesLogo.png') }}" alt="" /></a>
                    </div>
                    <div class="btn-group pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                GE
                                <span class="caret"></span>
                            </button>
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a href="#">EN</a></li>--}}
{{--                                <li><a href="#">RU</a></li>--}}
{{--                            </ul>--}}
                        </div>

                        <div class="btn-group">
                            <button type="button" class="btn btn-default dropdown-toggle usa" data-toggle="dropdown">
                                ლარი
                                <span class="caret"></span>
                            </button>
{{--                            <ul class="dropdown-menu">--}}
{{--                                <li><a href="#">USD</a></li>--}}
{{--                                <li><a href="#">EURO</a></li>--}}
{{--                            </ul>--}}
                        </div>
                    </div>
                </div>
                <div class="col-sm-8">
                    <div class="shop-menu pull-right">
                        <ul class="nav navbar-nav">
                            <li><a href="#"><i class="fa fa-user"></i>ექაუნთი</a></li>
{{--                            <li><a href="#"><i class="fa fa-star"></i> სურვილები</a></li>--}}
{{--                            <li><a href="checkout.html"><i class="fa fa-crosshairs"></i> გადახდა</a></li>--}}
                            <li><a href="{{ url('/cart') }}"><i class="fa fa-shopping-cart"></i> კალათი</a></li>
{{--                            <li><a href="login.html"><i class="fa fa-lock"></i> შესვლა</a></li>--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-middle-->

    <div class="header-bottom"><!--header-bottom-->
        <div class="container">
            <div class="row">
                <div class="col-sm-9">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="mainmenu pull-left">
                        <ul class="nav navbar-nav collapse navbar-collapse">
                            <li><a href="{{ url('/') }}" class="active">მთავარი</a></li>
                            @foreach($sections as $section)
                                @if(count($section['categories'])>0)
                            <li class="dropdown"><a href="#">{{ $section['name'] }}<i class="fa fa-angle-down"></i></a>
                                <ul role="menu" class="sub-menu">
                                    @foreach($section['categories'] as $category)
                                    <li><a href="{{ url('/'.$category['url']) }}">{{ $category['category_name'] }}</a></li>
                                    @foreach($category['subcategories'] as $subcategory)
                                    <li><a href="{{ $subcategory['url'] }}">{{ $subcategory['category_name'] }}</a></li>
                                    @endforeach
                                    @endforeach
                                </ul>
                            </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="search_box pull-right">
                        <input type="text" placeholder="ძებნა"/>
                    </div>
                </div>
            </div>
        </div>
    </div><!--/header-bottom-->
</header><!--/header-->
