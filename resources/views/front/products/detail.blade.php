<?php
    use App\Models\Product;
?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-9 padding-right">
                    <div class="product-details"><!--product-details-->
                        <div class="col-sm-5">
                            <div class="view-product" id="gallery">
                                <a target="_blank" href="{{ asset('images/product_images/large/'.$productDetails['main_image']) }}">
                                <img src="{{ asset('images/product_images/large/'.$productDetails['main_image']) }}" alt="" /></a>
                                <h3>ZOOM</h3>
                            </div>
                            <div id="similar-product" class="carousel slide" data-ride="carousel">
                                <!-- Wrapper for slides -->
                                <div class="carousel-inner">
                                    <div class="item active">
                                        @foreach($productDetails['images'] as $image)
                                            <a target="_blank" href="{{ asset('images/product_images/large/'.$image['image']) }}"><img style="width: 29%;" src="{{ asset('images/product_images/small/'.$image['image']) }}" alt=""></a>
                                        @endforeach
                                    </div>
                                    <div class="item">
                                        @foreach($productDetails['images'] as $image)
                                            <a target="_blank" href="{{ asset('images/product_images/large/'.$image['image']) }}"><img style="width: 29%;" src="{{ asset('images/product_images/small/'.$image['image']) }}" alt=""></a>
                                        @endforeach
                                    </div>
                                    <div class="item">
                                        @foreach($productDetails['images'] as $image)
                                            <a target="_blank" href="{{ asset('images/product_images/large/'.$image['image']) }}"><img style="width: 29%;" src="{{ asset('images/product_images/small/'.$image['image']) }}" alt=""></a>
                                        @endforeach
                                    </div>
                                </div>
                                <!-- Controls -->
                                <a class="left item-control" href="#similar-product" data-slide="prev">
                                    <i class="fa fa-angle-left"></i>
                                </a>
                                <a class="right item-control" href="#similar-product" data-slide="next">
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>

                        </div>
                        <div class="col-sm-7">
                            @if(Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                                    {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if(Session::has('error_message'))
                                <div class="alert alert-danger" role="alert">
                                    {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <div class="product-information"><!--/product-information-->
                                <h2>{{ $productDetails['product_name'] }}</h2>
                                <p>კოდი: {{ $productDetails['product_code'] }}</p>
                                <hr class="soft">
                                <span>
                                    <form action="{{ url('add-to-cart') }}" method="post" class="form-horizontal qtyFrm">@csrf
                                        <input type="hidden" name="product_id" value="{{ $productDetails['id'] }}">
                                        <div class="control-group">
                                            <?php $discounted_price = Product::getDiscountedPrice($productDetails['id']); ?>
                                                <h3 class="getAttrPrice" style="color: #FE980F; font-weight: 900;">
                                                    @if($discounted_price < $productDetails['product_price'])
                                                        <del>{{ $productDetails['product_price'] }} ₾.</del>
                                                        <font color="red"> {{ $discounted_price }} ₾.</font>
                                                    @else
                                                        {{ $productDetails['product_price'] }} ₾.
                                                    @endif
                                                </h3>
                                            <select name="size" id="getPrice" product_id="{{ $productDetails['id'] }}" class="span2 pull-left" style="width: 150px;" required="">
                                                <option value="">აირჩიეთ ზომა</option>
                                                @foreach($productDetails['attributes'] as $attribute)
                                                    <option value="{{ $attribute['size'] }}">{{ $attribute['size'] }}</option>
                                                @endforeach
                                            </select>
                                            &nbsp;&nbsp;
                                            <input name="quantity" type="number" min="1" class="span2" placeholder="ც.">
                                            <button type="submit" class="btn btn-default cart">
										        <i class="fa fa-shopping-cart"></i>
										            დამატება
									        </button>
                                        </div>
                                    </form>
								</span>
                                <p><b>გაყიდვაშია:</b> {{ $total_stock }} წყვილი</p>
                                <p><b>ბრენდი:</b> {{ $productDetails['brand']['name'] }}</p>
                                <p><b>ფერი:</b> {{ $productDetails['product_color'] }}</p>
                                <a href=""><img src="{{ asset('images//product-details/share.png') }}" class="share img-responsive"  alt="" /></a>
                            </div><!--/product-information-->
                        </div>
                    </div><!--/product-details-->

                    <div class="category-tab shop-details-tab"><!--category-tab-->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="reviews" >
                                <div class="col-sm-12">
                                    <p>{{ $productDetails['description'] }}</p>
                                </div>
                            </div>

                        </div>
                    </div><!--/category-tab-->

                    <div class="recommended_items"><!--recommended_items-->
                        <h2 class="title text-center">recommended items</h2>

                        <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend1.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend2.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend3.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend1.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend2.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="product-image-wrapper">
                                            <div class="single-products">
                                                <div class="productinfo text-center">
                                                    <img src="images/home/recommend3.jpg" alt="" />
                                                    <h2>$56</h2>
                                                    <p>Easy Polo Black Edition</p>
                                                    <button type="button" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>
                    </div><!--/recommended_items-->

                </div>
            </div>
        </div>
    </section>
@endsection
