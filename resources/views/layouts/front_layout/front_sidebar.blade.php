<?php
use App\Models\Sections;
use App\Models\Brand;

$sections = Sections::sections();
$brands = Brand::brands();
?>
<div class="col-sm-3">
    <div class="left-sidebar">
        <h2>კატეგორიები</h2>
        <div class="panel-group category-products" >
            @foreach($sections as $section)
                @if(count($section['categories'])>0)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a href="#">
                            {{ $section['name'] }}
                        </a>
                    </h4>
                </div>
                <div class="panel-collapse">
                    <div class="panel-body">
                        <ul>
                            @foreach($section['categories'] as $category)
                            <li><a href="{{ url('/'.$category['url']) }}">{{ $category['category_name'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
                @endif
            @endforeach
        </div><!--/category-products-->
        <div class="brands_products"><!--brands_products-->
            <h2>ბრენდები</h2>
            <div class="brands-name">
                <ul class="nav nav-pills nav-stacked">
                    @foreach($brands as $brand)
                    <li><a href="#"> <span class="pull-right">{{ count($brand) }}</span>{{ $brand['name'] }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div><!--/brands_products-->
{{--        <div class="price-range"><!--price-range-->--}}
{{--            <h2>ფასი</h2>--}}
{{--            <div class="well text-center">--}}
{{--                <input type="text" class="span2" value="" data-slider-min="0" data-slider-max="1000" data-slider-step="5" data-slider-value="[250,450]" id="sl2" ><br />--}}
{{--                <b class="pull-left">0 ₾</b> <b class="pull-right">1000 ₾</b>--}}
{{--            </div>--}}
{{--        </div><!--/price-range-->--}}

        <div class="shipping text-center"><!--shipping-->
            <img src="{{ asset('images/front_images/home/shipping.jpg') }}" alt="" />
        </div><!--/shipping-->
    </div>
</div>
