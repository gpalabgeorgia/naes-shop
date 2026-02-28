<?php
use App\Models\Cart;
use App\Models\Product;
$item = Cart::userCartItems();
?>
<table class="table table-condensed">
    <thead>
        <tr class="cart_menu">
            <th style="text-align: center;" class="image">პროდუქტი</th>
            <th style="text-align: center;" class="description" colspan="2">აღწერა</th>
            <th style="text-align: center;" class="quantity">რაოდენობა</th>
            <th style="text-align: center;" class="price">ფასი ც.</th>
            <th style="text-align: center;">ფასდაკლება</th>
            <th style="text-align: center;" class="total">ფასი</th>
        </tr>
    </thead>
    <tbody>
        <?php $total_price = 0; ?>
        @foreach($userCartItems as $item)
                <?php $attrPrice = Product::getDiscountedAttrPrice($item['product_id'],$item['size']); ?>
            <tr>
                <td style="text-align: center;"> <img width="60" src="{{ asset('images/product_images/large/'.$item['product']['main_image']) }}" alt=""/></td>
                <td colspan="2">
                    {{ $item['product']['product_name'] }} ({{ $item['product']['product_code'] }})<br/>
                    ფერი: {{ $item['product']['product_color'] }} <br>
                    ზომა: {{ $item['size'] }}
                </td>
                <td style="text-align: center;">
                    <div style="display:flex; align-items:center; justify-content:center; gap:5px; flex-wrap:nowrap;">

                        <button class="btn btnItemUpdate qtyMinus" type="button" data-cartid="{{ $item['id'] }}" style="min-width:35px;">
                            <i class="fa-solid fa-minus"></i>
                        </button>

                        <input type="text" id="appendedInputButtons" value="{{ $item['quantity'] }}" size="16" style="width:60px; text-align:center; height:35px;">

                        <button class="btn btnItemUpdate qtyPlus" type="button" data-cartid="{{ $item['id'] }}" style="min-width:35px;">
                            <i class="fa-solid fa-plus"></i>
                        </button>

                        <button class="btn btnItemDelete"
                                type="button"
                                data-cartid="{{ $item['id'] }}"
                                style="min-width:35px; background:#FE980F; border:none;">
                            <i class="fa-solid fa-xmark"></i>
                        </button>

                    </div>
                </td>
                <td style="text-align: center;">{{ $attrPrice['product_price'] }} ₾.</td>
                <td style="text-align: center;">{{ $attrPrice['discount'] }} ₾.</td>
                <td style="text-align: center;">{{ $attrPrice['final_price'] * $item['quantity'] }} ₾.</td>
            </tr>
                <?php $total_price = $total_price + ($attrPrice['final_price'] * $item['quantity']); ?>
        @endforeach
        <tr>
            <td data-label="ფასი" colspan="6" style="text-align:right">ფასი: </td>
            <td style="text-align: center;">{{ $total_price }} ₾.</td>
        </tr>
        <tr>
            <td data-label="კუპონით ფასდაკლება" colspan="6" style="text-align:right">კუპონით ფასდაკლება: </td>
            <td data-label="ფასდაკლება" style="text-align: center;" class="couponAmount">
                @if(Session::has('CouponAmount'))
                    - {{ Sesion::get('CouponAmount') }} ₾.
                @else
                    0 ₾.
                @endif
            </td>
        </tr>
        <tr>
            <td data-label="სულ" colspan="6" style="text-align:right"><strong>სულ ({{ $total_price }} ₾. - <strong class="couponAmount">0 ₾.</strong>) = </strong></td>
            <td data-label="ჯამი" style="background-color: #FE980F; text-align: center;">{{ $total_price }} ₾.</td>
        </tr>
    </tbody>
</table>
