<?php
    use App\Models\Banner;
    $getBanners = Banner::getBanners();
?>
@if(isset($page_name) && $page_name=="Index")
<section id="slider"><!--slider-->
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="col-sm-6">
                                <h1><span>NAES</span>-SHOPP</h1>
                                <h2>ევროპული ონლაინ მაღაზია</h2>
                                <p>მაღაზიაში ევროპის ქვეყნების პროდუქციაა წარმოდგენილი. ჩვენთან შეგიძლიათ შეიძინოთ ესპანური, იტალიური, ფრანგული, გერმანული პროდუქცია</p>
                            </div>
                            @foreach($getBanners as $key => $banner)
                            <div class="col-sm-6">
                                <img src="{{ asset('images/banner_images/'.$banner['image']) }}" class="girl img-responsive" alt="" />
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section><!--/slider-->
    @endif
