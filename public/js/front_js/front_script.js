$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $("#getPrice").change(function() {
        let size = $(this).val();
        if(size=="") {
            alert("გთხოვთ აირჩიოთ ზომა");
            return false;
        }
        let product_id = $(this).attr("product_id");
        $.ajax({
            url: '/get-product-price',
            data: {size:size,product_id:product_id},
            type: 'post',
            success: function(resp) {
                if(resp['discount'] > 0) {
                    $(".getAttrPrice").html("<del> "+resp['product_price'] + " ₾.</del> " + resp['final_price']);
                }else {
                    $(".getAttrPrice").html(resp['product_price'] + " ₾.");
                }

            }, error: function(resp) {
                alert("Error");
            }
        });
    });

    // Update Cart Items
    $(document).on('click', '.btnItemUpdate', function() {
        if($(this).hasClass('qtyMinus')) {
            // if qtyMinus button gets clicked by User
            let quantity = $(this).next().val();
            if(quantity<=1) {
                alert('დაუშვებელია 1-ზე ნაკლები პროდუქტი!');
                return false;
            }else {
                new_qty = parseInt(quantity) - 1;
            }
        }
        if($(this).hasClass('qtyPlus')) {
            // if qtyPlus button gets clicked by User
            let quantity = $(this).prev().val();
            new_qty = parseInt(quantity) + 1;
        }
        let cartId = $(this).data('cartid');
        // alert('cartId');
        $.ajax({
            data:{'cartid':cartId, "qty":new_qty},
            url:'/update-cart-item-qty',
            type: 'post',
            success:function(resp) {
                // alert(resp);
                $('#AppendCartItems').html(resp.view);
            },error:function() {
                alert('წარმოიშვა შეცდომა!');
            }
        });
    });
});
