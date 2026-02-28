<html>
    <body>
        <table style="width: 700px;">
            <tr><td>&nbsp;</td></tr>
            <tr><td><img style="width: 100px;" src="{{ $message->embed(public_path('images/front_images/logo_email.png')) }}" alt="Logo Email"></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>მოგესალმებით ძვირფასო {{ $name }},</td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>თქვენი შეკვეთის № {{ $order_id }} სტატუსი გაახლდა - {{ $order_status }}.</td></tr>
            @if(!empty($courier_name) && !empty($tracking_number))
            <tr><td>&nbsp;</td></tr>
            <tr><td>კურიერის სახელი: {{ $courier_name }} <br> გზავნილის ნომერი: {{ $tracking_number }}</td></tr>
            @endif
            <tr><td>&nbsp;</td></tr>
            <tr><td>შეკვეთის დეტალები იხილეთ ქვემოთ: </td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table style="width: 95%;" cellpadding="5" cellspacing="5" bgcolor="#f7f4f4">
                        <tr bgcolor="#ccc">
                            <td>პროდუქტის სახელი</td>
                            <td>კოდი</td>
                            <td>ზომა</td>
                            <td>ფერი</td>
                            <td>რაოდენობა</td>
                            <td>ფასი</td>
                        </tr>
                        @foreach($orderDetails['orders_products'] as $order)
                            <tr>
                                <td>{{ $order['product_name'] }}</td>
                                <td>{{ $order['product_code'] }}</td>
                                <td>{{ $order['product_size'] }}</td>
                                <td>{{ $order['product_color'] }}</td>
                                <td>{{ $order['product_qty'] }}</td>
                                <td>{{ $order['product_price'] }} ₾.</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" align="right">მიწოდების ფასი</td>
                            <td>{{ $orderDetails['shipping_charges'] }} ₾.</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">კუპონით ფასდაკლება</td>
                            <td>
                                @if($orderDetails['coupon_amount']>0)
                                    {{ $orderDetails['coupon_amount'] }} ₾.</td>
                            @else
                                0
                            @endif
                        </tr>
                        <tr>
                            <td colspan="5" align="right">სულ გადასახდელი</td>
                            <td>{{ $orderDetails['grand_total'] }} ₾.</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr>
                <td>
                    <table>
                        <tr>
                            <td><strong>მიწოდების მისამართი: </strong></td>
                        </tr>
                        <tr>
                            <td><strong>სახელი/გვარი</strong></td>
                            <td>{{ $orderDetails['name'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>მისამართი</strong></td>
                            <td>{{ $orderDetails['address'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>ქალაქი</strong></td>
                            <td>{{ $orderDetails['city'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>რეგიონი</strong></td>
                            <td>{{ $orderDetails['state'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>ქვეყანა</strong></td>
                            <td>{{ $orderDetails['country'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>პინკოდი: </strong></td>
                            <td>{{ $orderDetails['pincode'] }}</td>
                        </tr>
                        <tr>
                            <td><strong>ტელეფონი: </strong></td>
                            <td>{{ $orderDetails['mobile'] }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>შეკითხვების წარმოშობის შემთხვევაში დაგვიკავშირდით <a href="mailto:naes@info.com">naes@info.com</a></td></tr>
            <tr><td>&nbsp;</td></tr>
            <tr><td>კეთილი სურვილებით, <br> NAES-ის ადმინისტრაცია</td></tr>
            <tr><td>&nbsp;</td></tr>
        </table>
    </body>
</html>
