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
});
