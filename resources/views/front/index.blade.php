@php use App\Models\Product; @endphp
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="col-sm-9 padding-right">
        <div class="recommended_items"><!--recommended_items-->
            <h2 class="title text-center">ბოლოს დამატებულია</h2>
            @foreach($featuredItemsChunk as $key => $featuredItem)
            <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    @foreach($featuredItem as $item)
                        <div class="item active">
                                <div class="col-sm-4">
                                    <div class="product-image-wrapper">
                                        <div class="single-products">
                                            <div class="productinfo text-center">
                                                <?php $product_image_path = 'images/product_images/small/'.$item['main_image']; ?>
                                                <img src="{{ asset($product_image_path) }}" alt="" />
                                                <h2>{{ $item['product_price'] }} ₾.</h2>
                                                <p>{{ $item['product_name'] }}</p>
                                                <a href="#" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i> დეტალურად</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div><!--/recommended_items-->

        <div class="features_items"><!--features_items-->
            <h2 class="title text-center">ახალი პროდუქცია</h2>
            @foreach($newProducts as $product)
            <div class="col-sm-4">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo text-center">
                            <?php $product_image_path = 'images/product_images/large/'.$product['main_image']; ?>
                            <img src="{{ asset($product_image_path) }}" alt="" />
                                <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                                <h2>
                                    @if($discounted_price>0)
                                        <del>{{ $product['product_price'] }} ₾.</del>
                                        <font color="red">{{ $discounted_price }} ₾.</font>
                                    @else
                                        {{ $product['product_price'] }}
                                    @endif
                                </h2>
                            <p>{{ $product['product_name'] }}</p>
                            <p>{{ $product['product_code'] }}</p>
                            <a href="{{ url('product/'.$product['id']) }}" class="btn btn-default add-to-cart"><i class="fa fa-eye"></i> დეტალურად</a>
                        </div>
                    </div>
                    <div class="choose">
{{--                        <ul class="nav nav-pills nav-justified">--}}
{{--                            <li><a href="#"><i class="fa fa-plus-square"></i>სურვილებში</a></li>--}}
{{--                            <li><a href="#"><i class="fa fa-plus-square"></i>შესადარებლად</a></li>--}}
{{--                        </ul>--}}
                    </div>
                </div>
            </div>
            @endforeach
        </div><!--features_items-->
    </div>
@endsection
