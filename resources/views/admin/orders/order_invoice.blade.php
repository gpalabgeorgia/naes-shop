<link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<style>
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-xs-12">
            <div class="invoice-title">
                <h2>შეკვეთის </h2><h3 class="pull-right">ინვოისი № {{ $orderDetails['id'] }}</h3>
            </div>
            <hr>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>ანგარიში:</strong><br>
                        {{ $userDetails['name'] }}<br>
                        {{ $userDetails['address'] }}<br>
                        {{ $userDetails['city'] }}<br>
                        {{ $userDetails['state'] }}<br>
                        {{ $userDetails['country'] }}<br>
                        {{ $userDetails['pincode'] }}<br>
                        {{ $userDetails['mobile'] }}<br>
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        {{ $userDetails['name'] }}<br>
                        {{ $userDetails['address'] }}, {{ $userDetails['city'] }}<br>
                        {{ $userDetails['state'] }}, {{ $userDetails['country'] }}<br>
                        {{ $userDetails['pincode'] }}, {{ $userDetails['mobile'] }}<br>
                    </address>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6">
                    <address>
                        <strong>გადახდის მეთოდი:</strong><br>
                        {{ $orderDetails['payment_method'] }}
                    </address>
                </div>
                <div class="col-xs-6 text-right">
                    <address>
                        <strong>შეკვეთის თარიღი:</strong><br>
                        {{ date('d-m-Y', strtotime($orderDetails['created_at'])) }}<br><br>
                    </address>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title"><strong>შეკვეთის დეტალები</strong></h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed">
                            <thead>
                            <tr>
                                <td><strong>პროდუქტი</strong></td>
                                <td class="text-center"><strong>ფასი</strong></td>
                                <td class="text-center"><strong>რაოდენობა</strong></td>
                                <td class="text-right"><strong>სულ</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach($orderDetails['orders_products'] as $product)
                            <tr>
                                <td>
                                    დასახელება: {{ $product['product_name'] }}<br>
                                    კოდი: {{ $product['product_code'] }}<br>
                                    ზომა: {{ $product['product_size'] }}<br>
                                    ფერი: {{ $product['product_color'] }}<br>
                                </td>
                                <td class="text-center">{{ $product['product_price'] }} ₾.</td>
                                <td class="text-center">{{ $product['product_qty'] }}</td>
                                <td class="text-right">{{ $product['product_price'] * $product['product_qty']}} ₾. </td>
                            </tr>
                            @php $subtotal = $subtotal + $product['product_price'] * $product['product_qty'] @endphp
                            @endforeach
                            <tr>
                                <td class="thick-line"></td>
                                <td class="thick-line"></td>
                                <td class="thick-line text-center"><strong>ფასი</strong></td>
                                <td class="thick-line text-right">{{ $subtotal }} ₾.</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>ფასდაკლება</strong></td>
                                <td class="no-line text-right">@if(!empty($orderDetails['coupon_amount'])){{ $orderDetails['coupon_amount'] }} ₾. @else 0 ₾. @endif</td>
                            </tr>
                            <tr>
                                <td class="no-line"></td>
                                <td class="no-line"></td>
                                <td class="no-line text-center"><strong>ჯამი</strong></td>
                                <td class="no-line text-right">{{ $orderDetails['grand_total'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
