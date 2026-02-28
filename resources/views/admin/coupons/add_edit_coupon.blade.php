@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>კატალოგი</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">დაფა</a></li>
              <li class="breadcrumb-item active">კუპონები</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        @if($errors->any())
            <div class="alert alert-danger" style="margin-top: 10px;">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            </div>
        @endif
        @if(Session::has('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button> 
            </div>
        @endif
        <form @if(empty($coupon['id'])) action="{{ url('admin/add-edit-coupon') }}" @else action="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}" @endif name="couponForm" id="couponForm" method="post" enctype="multipart/form-data">@csrf
            <div class="card card-default">
            <div class="card-header">
                <h3 class="card-title">{{ $title }}</h3>
                <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        @if(empty($coupon['coupon_code']))
                            <div class="form-group">
                                <label for="coupon_option">კუპონის მონაცემები</label><br>
                                <span><input id="AutomaticCoupon" type="radio" name="coupon_option" id="coupon_option" value="Automatic" checked="">&nbsp;უვადო</span>&nbsp;&nbsp;
                                <span><input id="ManualCoupon" type="radio" name="coupon_option" id="coupon_option" value="Manual">&nbsp;ვადიანი</span>&nbsp;&nbsp;
                            </div>
                            <div class="form-group" style="display: none;" id="couponField">
                                <label for="coupon_code">კუპონის კოდი</label>
                                <input type="text" class="form-control" id="coupon_code" name="coupon_code" placeholder="კუპონის კოდი">
                            </div>
                        @else
                            <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                            <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                            <div class="form-group">
                                <label for="coupon_code">კუპონის კოდი: </label>
                                <span>{{ $coupon['coupon_code'] }}</span>
                            </div>
                        @endif
                            <div class="form-group">
                                <label for="coupon_type">კუპონის ტიპი</label><br>
                                <span><input type="radio" name="coupon_type" value="Multiple Times" @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Multiple Times") checked="" @elseif(!isset($coupon['coupon_type'])) checked="" @endif>&nbsp;მრავალჯერადი</span>&nbsp;&nbsp;
                                <span><input type="radio" name="coupon_type" value="Single Type" @if(isset($coupon['coupon_type'])&&$coupon['coupon_type']=="Single Type") checked="" @endif>&nbsp;ერთჯერადი</span>&nbsp;&nbsp;
                            </div>
                            <div class="form-group">
                                <label for="amount_type">ფასდაკლების ტიპი</label><br>
                                <span><input type="radio" name="amount_type" id="amount_type" value="Percentage" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Percentage") checked="" @elseif(!isset($coupon['amount_type'])) checked="" @endif>&nbsp;პროცენტული</span>&nbsp;(%-ში)&nbsp;
                                <span><input type="radio" name="amount_type" id="amount_type"  value="Fixed" @if(isset($coupon['amount_type'])&&$coupon['amount_type']=="Fixed") checked="" @endif>&nbsp;ფიქსირებული</span>&nbsp;(₾-ში)&nbsp;
                            </div>
                            <div class="form-group" id="couponField">
                                <label for="amount">ფასდაკლება</label>
                                <input type="number" class="form-control" id="amount" name="amount" placeholder="ფასდაკლება" required="" @if(isset($coupon['amount'])) value="{{ $coupon['amount'] }}" @endif>
                            </div>
                    </div>
                </div>
                <div class="row"> 
                    <div class="col-12 col-sm-6">
                        <div class="form-group">
                            <label for="categories">აირჩიეთ კატეგორია</label>
                            <select class="form-control select2" name="categories[]"  multiple="" required="">
                                <option value="">არჩევა</option>
                                @foreach($categories as $section)
                                    <optgroup label="{{ $section['name'] }}"></optgroup>
                                    @foreach($section['categories'] as $category)
                                        <option value="{{ $category['id'] }}" @if(in_array($category['id'], $selCats)) selected="" @endif>&nbsp;&nbsp;--&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                        @foreach($category['subcategories'] as $subcategory)
                                            <option value="{{ $subcategory['id'] }}" @if(in_array($subcategory['id'], $selCats)) selected="" @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="users">აირჩიეთ მომხმარებელი</label>
                            <select class="form-control select2" name="users[]"  multiple="">
                                <option value="">არჩევა</option>
                                @foreach($users as $user)
                                   <option value="{{ $user['email'] }}" @if(in_array($user['email'], $selUsers)) selected="" @endif>{{ $user['email'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="expiry_date">მოქმედების ვადა</label>
                            <input type="text" class="form-control" id="expiry_date" name="expiry_date" placeholder="მოქმედების ვადა" data-inputmask-alias="datetime" data-inputmask-inputformat="yyyy/mm/dd" data-mask required="" @if(isset($coupon['expiry_date'])) value="{{ $coupon['expiry_date'] }}" @endif>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">დადასტურება</button>
            </div>
            </div>
        </form>
      </div>
    </section>
  </div>    
@endsection

