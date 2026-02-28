@extends('layouts.admin_layouts.admin_layout')
@section('content')
<div class="content-wrapper">
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>პროდუქტები</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">მთავარი</a></li>
              <li class="breadcrumb-item active">ორდერები</li>
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
                {{ Session::forget('success_message') }}
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">ორდერები</h3>
                </div>
              <div class="card-body">
                <table id="orders" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>თარიღი</th>
                    <th>სახელი/გვარი</th>
                    <th>ელ.ფოსტა</th>
                    <th>პროდუქტი</th>
                    <th>ფასი</th>
                    <th>სტატუსი</th>
                    <th>გადახდა</th>
                    <th>მოქმედებები</th>
                  </tr>
                  </thead>
                  <tbody>
                    @foreach($orders as $order)
                  <tr>
                    <td>{{ $order['id'] }}</td>
                    <td>{{ date('d-m-Y', strtotime($order['created_at'])) }}</td>
                    <td>{{ $order['name'] }}</td>
                    <td>{{ $order['email'] }}</td>
                    <td>
                        @foreach($order['orders_products'] as $pro)
                            {{ $pro['product_code'] }} ({{ $pro['product_qty'] }})<br>
                        @endforeach
                    </td>
                    <td>{{ $order['grand_total'] }}</td>
                    <td>{{ $order['order_status'] }}</td>
                    <td>{{ $order['payment_method'] }}</td>
                    <td>
                      <a title="შეკვეთის დეტალების ნახვა" href="{{ url('admin/orders/'.$order['id']) }}"><i class="fas fa-file"></i></a>&nbsp;&nbsp;
                        @if($order['order_status']=='Shipped' || $order['order_status']=='Delivered')
                        <a title="შეკვეთის ინვოისის ნახვა" target="_blank" href="{{ url('admin/view-order-invoice/'.$order['id']) }}"><i class="fas fa-print"></i></a>
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
