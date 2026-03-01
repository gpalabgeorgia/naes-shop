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

    document.querySelectorAll('#similar-product img').forEach(function(img){
        img.addEventListener('click', function(e){
            e.preventDefault();

            // Получаем путь изображения
            let newSrc = this.src;

            // Меняем главное фото
            document.querySelector('#gallery img').src = newSrc;

            // Если есть ссылка для zoom
            document.querySelector('#gallery a').href = newSrc;
        });
    });

    const gallery = document.getElementById("gallery");
    const img = document.getElementById("mainZoomImage");

    const zoomLevel = 2.6;
    let isZoomed = false;

    gallery.addEventListener("mousemove", function(e){

        let rect = img.getBoundingClientRect();

        let x = e.clientX - rect.left;
        let y = e.clientY - rect.top;

        if(x < 0 || y < 0 || x > rect.width || y > rect.height) return;

        let xPercent = (x / rect.width) * 100;
        let yPercent = (y / rect.height) * 100;

        img.style.transform = `scale(${zoomLevel})`;
        img.style.transformOrigin = `${xPercent}% ${yPercent}%`;

        isZoomed = true;
    });

    gallery.addEventListener("mouseleave", function(){
        img.style.transform = "scale(1)";
        isZoomed = false;
    });

    const modal = document.getElementById("imageModal");
    const modalImg = document.getElementById("modalImage");
    const closeModal = document.getElementById("closeModal");

    const prevBtn = document.getElementById("prevImage");
    const nextBtn = document.getElementById("nextImage");

    const galleryImages = Array.from(
        document.querySelectorAll("#similar-product img")
    );

    let currentIndex = 0;

// Open modal on main image click
    document.getElementById("mainZoomImage").addEventListener("click", function(){
        modal.style.display = "flex";
        modalImg.src = this.src;

        currentIndex = galleryImages.findIndex(img => img.src === this.src);
    });

// Close modal
    closeModal.onclick = () => modal.style.display = "none";

// Navigation functions
    function showImage(index){

        if(index < 0) index = galleryImages.length - 1;
        if(index >= galleryImages.length) index = 0;

        currentIndex = index;

        // Smooth fade out + scale down
        modalImg.style.opacity = "0";
        modalImg.style.transform = "scale(0.95)";

        setTimeout(() => {

            modalImg.src = galleryImages[currentIndex].src;

            // Wait for image load before showing
            modalImg.onload = () => {
                modalImg.style.opacity = "1";
                modalImg.style.transform = "scale(1)";
            };

        }, 180);
    }

    prevBtn.onclick = () => showImage(currentIndex - 1);
    nextBtn.onclick = () => showImage(currentIndex + 1);

// Click outside = close
    modal.onclick = function(e){
        if(e.target === modal){
            modal.style.display = "none";
        }
    };

    document.getElementById("mainZoomImage").addEventListener("click", function(){

        modal.style.display = "flex";

        modalImg.style.opacity = "0";
        modalImg.style.transform = "scale(0.9)";

        modalImg.src = this.src;

        setTimeout(()=>{
            modalImg.style.opacity = "1";
            modalImg.style.transform = "scale(1)";
        },150);

        currentIndex = galleryImages.findIndex(img => img.src === this.src);
    });
});
