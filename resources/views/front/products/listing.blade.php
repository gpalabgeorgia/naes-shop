@php use App\Models\Product; @endphp
@extends('layouts.front_layout.front_layout')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 padding-right">
                    <div class="features_items"><!--features_items-->
                        <h2 class="title text-center">{{ $categoryDetails['catDetails']['category_name'] }}</h2>
                        @foreach($categoryProducts as $product)
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                    <div class="single-products">
                                        <div class="productinfo text-center">
                                            <?php $product_image_path = 'images/product_images/large/'.$product['main_image']; ?>
                                            <img src="{{ asset($product_image_path) }}" alt="" />
                                            <?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
                                            @if($discounted_price > 0)
                                                <h2><del>{{ $product['product_price'] }}</del> ₾.</h2>
                                            @else
                                                <h2>{{ $product['product_price'] }} ₾.</h2>
                                            @endif
                                            @if($discounted_price > 0)
                                                <h4 style="color: red;">ფასდაკლებით: {{ $discounted_price }} ₾.</h4>
                                            @endif
                                            <p>{{ $product['product_name'] }}</p>
                                            <p>{{ $product['brand']['name'] }}</p>
                                            <a href="{{ url('product/'.$product['id']) }}" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>დეტალურად</a>
                                        </div>
                                    </div>
                            </div>
                        </div>
                        @endforeach
                        @if ($categoryProducts->hasPages())
                            {{ $categoryProducts->links() }}
                        @endif
                    </div><!--features_items-->
                </div>
            </div>
        </div>
    </section>
@endsection
