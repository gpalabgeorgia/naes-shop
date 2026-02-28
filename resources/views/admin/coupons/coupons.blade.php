@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>ბანერები</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">მთავარი</a></li>
              <li class="breadcrumb-item active">კუპონები</li>
            </ol>
          </div>
        </div>
      </div>
    </section>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            @if(Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                  {{ Session::get('success_message') }}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button> 
                </div>
              @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">კუპონები</h3>
                    <a href="{{ url('admin/add-edit-coupon') }}" class="btn btn-block btn-success" style="max-width: 150px; float: right; display: inline-block;">დამატება</a>
                </div>
              <div class="card-body">
                <table id="coupons" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>კოდი</th>
                    <th>კუპონის ტიპი</th>
                    <th>ღირებულება</th>
                    <th>მოქმედების ვადა</th>
                    <th>მოქმედებები</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($coupons as $coupon)
                  <tr>
                    <td>{{ $coupon['id'] }}</td>
                    <td>{{ $coupon['coupon_code'] }}</td>
                    <td>{{ $coupon['coupon_type'] }}</td>
                    <td>
                        {{ $coupon['amount'] }}
                        @if($coupon['amount_type']=="Percentage")
                            %
                        @else 
                            ₾.
                        @endif
                    </td>
                    <td>{{ $coupon['expiry_date'] }}</td>
                    <td>
                      <a title="კუპონის რედაქტირება" href="{{ url('admin/add-edit-coupon/'.$coupon['id']) }}"><i class="fas fa-edit"></i></a>
                      &nbsp;&nbsp;
                      <a title="კუპონის წაშლა" href="javascript:void(0)" class="confirmDelete" record="coupon" recordid="{{ $coupon['id'] }}"><i class="fas fa-trash"></i></a>
                      &nbsp;&nbsp;
                      @if($coupon['status']==1)
                          <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                      @else
                          <a class="updateCouponStatus" id="coupon-{{ $coupon['id'] }}" coupon_id="{{ $coupon['id'] }}" href="javascript:void(0)"><i class="fas fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                      @endif
                    </td>
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
@endsection