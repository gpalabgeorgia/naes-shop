<?php
    use App\Models\Product;
?>
@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
        @if(Session::has('success_message'))
            <div class="col-sm-12">
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                    {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            {{ Session::forget('success_message') }}
        @endif
          <div class="col-sm-6">
            <h1>შეკვეთის დეტალები</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">მთავარი</a></li>
              <li class="breadcrumb-item active">ორდერი # {{ $orderDetails['id'] }} დეტალურად</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><strong>შეკვეთის დეტალები</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>შეკვეთის თარიღი</strong></td>
                                        <td>{{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>შეკვეთის სტატუსი</strong></td>
                                        <td>{{ $orderDetails['order_status'] }}</td>
                                    </tr>
                                    @if(!empty($orderDetails['courier_name']))
                                        <tr>
                                            <td><strong>კურიერის სახელი</strong></td>
                                            <td>{{ $orderDetails['courier_name'] }}</td>
                                        </tr>
                                    @endif
                                    @if(!empty($orderDetails['tracking_number']))
                                        <tr>
                                            <td><strong>გზავნილის ნომერი</strong></td>
                                            <td>{{ $orderDetails['tracking_number'] }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td><strong>შეკვეთის ჯამი</strong></td>
                                        <td>{{ $orderDetails['grand_total'] }} ₾.</td>
                                    </tr>
                                    <tr>
                                        <td><strong>გაგზავნის ფასი</strong></td>
                                        <td>{{ $orderDetails['shipping_charges'] }} ₾.</td>
                                    </tr>
                                    {{--                <tr>--}}
                                    {{--                    <td><strong>კუპონის კოდი</strong></td>--}}
                                    {{--                    <td>{{ $orderDetails['coupon_code'] }}</td>--}}
                                    {{--                </tr>--}}
                                    {{--                <tr>--}}
                                    {{--                    <td><strong>კუპონით ფასდაკლება</strong></td>--}}
                                    {{--                    <td>{{ $orderDetails['coupon_amount'] }}</td>--}}
                                    {{--                </tr>--}}
                                    <tr>
                                        <td><strong>გადახდის მეთოდი</strong></td>
                                        <td>{{ $orderDetails['payment_method'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>გადახდის შლუზი</strong></td>
                                        <td>{{ $orderDetails['payment_method'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2"><strong>მიწოდების მისამართი</strong></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"></td>
                                    </tr>
                                    <tr>
                                        <td>სახელი / გვარი</td>
                                        <td>{{ $orderDetails['name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>მისამართი</td>
                                        <td>{{ $orderDetails['address'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>ქალაქი</td>
                                        <td>{{ $orderDetails['city'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>რეგიონი</td>
                                        <td>{{ $orderDetails['state'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>ქვეყანა</td>
                                        <td>{{ $orderDetails['country'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>პინკოდი</td>
                                        <td>{{ $orderDetails['pincode'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>ტელეფონი</td>
                                        <td>{{ $orderDetails['mobile'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="2"><strong>ინფორმაცია მომხმარებელზე</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>სახელი / გვარი</td>
                                    <td>{{ $userDetails['name'] }}</td>
                                </tr>
                                <tr>
                                    <td>ელ.ფოსტა</td>
                                    <td>{{ $userDetails['email'] }}</td>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="2"><strong>რეკვიზიტები</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td>სახელი / გვარი</td>
                                    <td>{{ $userDetails['name'] }}</td>
                                </tr>
                                <tr>
                                    <td>მისამართი</td>
                                    <td>{{ $userDetails['address'] }}</td>
                                </tr>
                                <tr>
                                    <td>ქალაქი</td>
                                    <td>{{ $userDetails['city'] }}</td>
                                </tr>
                                <tr>
                                    <td>რეგიონი</td>
                                    <td>{{ $userDetails['state'] }}</td>
                                </tr>
                                <tr>
                                    <td>ქვეყანა</td>
                                    <td>{{ $userDetails['country'] }}</td>
                                </tr>
                                <tr>
                                    <td>პინკოდი</td>
                                    <td>{{ $userDetails['pincode'] }}</td>
                                </tr>
                                <tr>
                                    <td>ტელეფონი</td>
                                    <td>{{ $userDetails['mobile'] }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <table class="table table-bordered">
                                <tbody>
                                <tr>
                                    <td colspan="2"><strong>შეკვეთის სტატუსის გაახლება</strong></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <form action="{{ url('admin/update-order-status') }}" method="post">@csrf
                                                <input type="hidden" name="order_id" value="{{ $orderDetails['id'] }}">
                                            <select name="order_status" id="order_status" required="">
                                                <option value="">აირჩიე სტატუსი</option>
                                                @foreach($orderStatuses as $status)
                                                    <option value="{{ $status['name'] }}" @if(isset($orderDetails['order_status']) && $orderDetails['order_status']==$status['name']) selected="" @endif>{{ $status['name'] }}</option>
                                                @endforeach
                                            </select>&nbsp;&nbsp;
                                            <input type="text" width="120px" name="courier_name" @if(empty($orderDetails['courier_name'])) id="courier_name" @endif placeholder="კურიერის სახელი" value="{{ $orderDetails['courier_name'] }}">
                                            <input type="text" width="120px" name="tracking_number" @if(empty($orderDetails['tracking_number'])) id="tracking_number" @endif placeholder="გზავნილის ნომერი" value="{{ $orderDetails['tracking_number'] }}">
                                            <button type="submit">დადასტურება</button>
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        @foreach($orderLog as $log)
                                            <strong>{{ $log['order_status'] }}</strong><br>
                                            {{ date('j F, Y, g:i a', strtotime($log['created_at'])) }}
                                            <hr>
                                        @endforeach
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">შეკვეთილი პროდუქტები</h3>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0" style="height: 300px;">
                        <table class="table table-head-fixed text-nowrap">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">ფოტო</th>
                                    <th style="text-align: center;">კოდი</th>
                                    <th style="text-align: center;">სახელი</th>
                                    <th style="text-align: center;">ზომა</th>
                                    <th style="text-align: center;">ფერი</th>
                                    <th style="text-align: center;">რაოდენობა</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orderDetails['orders_products'] as $product)
                                    <tr>
                                        <td style="text-align: center;">
                                            <?php $getProductImage = Product::getProductImage($product['product_id']) ?>
                                            <a target="_blank" href="{{ url('product/'.$product['product_id']) }}"><img style="width: 150px;" src="{{ asset('images/product_images/small/'.$getProductImage) }}" alt=""></a>
                                        </td>
                                        <td style="text-align: center">{{ $product['product_code'] }}</td>
                                        <td style="text-align: center">{{ $product['product_name'] }}</td>
                                        <td style="text-align: center">{{ $product['product_size'] }}</td>
                                        <td style="text-align: center">{{ $product['product_color'] }}</td>
                                        <td style="text-align: center">{{ $product['product_qty'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
