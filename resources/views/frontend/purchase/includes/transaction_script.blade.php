<script src="{{ asset('assets/js/app.js')}}"></script>
<script>
$('[data-toggle="popover"]').popover();
function loadingStart() {
    $('#loading_wrapper').show();
}

function loadingEnd() {
    $('#loading_wrapper').hide();
}

function subCheck() {
    $('.sub').each(function(){
        var $this = $(this);
        if ($(this).next('.p_qty').val() == 1) {
            $(this).addClass('btn-gray');
        }
    });

}

$(function() {
    // ADD TO CART
    // DETAIL

    $('body').on('click', '.process_loading', function(){
        loadingStart();
    });
    @auth
    $('body').on('click', '#add_to_cart_detail', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_count').val();
        loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.cart.add') }}",
            data: {
                id: id,
                qty: qty
            },
            success: function (data) {
                loadingEnd();

                if (data.status) {
                    $('#drop-cart').html(data.cartsmall);

                    swal("Success", "Succesfully add product to cart", "success");
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    $('body').on('click', '.add_to_cart_many', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_count' + id).val();
        loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.cart.add') }}",
            data: {
                id: id,
                qty: qty
            },
            success: function (data) {
                loadingEnd();
                if (data.status) {
                    $('#drop-cart').html(data.cartsmall);

                    swal("Success", "Succesfully add product to cart", "success");
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    $('body').on('click', '.add_to_cart_popup', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_popup_count' + id).val();
        loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.cart.add') }}",
            data: {
                id: id,
                qty: qty
            },
            success: function (data) {
                loadingEnd();
                if (data.status) {
                    $('#drop-cart').html(data.cartsmall);

                    swal("Success", "Succesfully add product to cart", "success");
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    $('body').on('click', '.add_to_cart_info', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_count_info' + id).val();
        loadingStart();

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.cart.add') }}",
            data: {
                id: id,
                qty: qty
            },
            success: function (data) {
                loadingEnd();
                if (data.status) {
                    $('#drop-cart').html(data.cartsmall);

                    swal("Success", "Succesfully add product to cart", "success");
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    // MISC
    $('body').on('click', '.add_to_cart', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = 1;

        $.ajax({
            type: 'POST',
            url: "{{ route('frontend.cart.add') }}",
            data: {
                id: id,
                qty: qty
            },
            success: function (data) {
                if (data.status) {
                    $('#drop-cart').html(data.cartsmall);

                    swal("Success", "Succesfully add product to cart", "success");
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });


    $("body").on('click', '.delete_cart_item', function (e) {
        e.preventDefault();
        var url = "{{ route('frontend.cart.delete') }}";
        var rand = $(this).attr('data-rand');

        Swal.fire({
            title: 'Are you sure?',
            text: "Are your sure to delete this product",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.value) {
            loadingStart();

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: {
                        id: rand,
                    },
                    cache: false,
                    success: function (data) {
                        loadingEnd();
                        if (data.status) {
                            $('#drop-cart').html(data.cartsmall);
                            $("#shopping_cart_wrapper").load(' #shopping_cart_content');
                            swal("Success", data.message, "success");
                        } else {
                            swal("Error", 'Failed to delete from cart', "error");
                        };

                        $('#remove-product').attr('disabled', false);
                    }
                });
            }
        })
    });


    var clickTimeout;
    $("body").on('click', '.btn_change_qty', function (e) {
        e.preventDefault();
        clearTimeout(clickTimeout);
        var input = $(this).siblings('.p_qty');
        var oldVal = $(this).siblings('.p_qty').val();
        var newVal = (parseInt(input.val(),10));

        input.val(newVal);

        clickTimeout = setTimeout(function(){
            input.trigger('change');
        }, 500);
    });

    $("body").on('change keyup', '.p_qty', function (e) {
        e.preventDefault();
        var val = $(this).val();
        var rand = $(this).data('rand');
        updateCart(rand, val);
    });

    function updateCart(rand, qty) {
        loadingStart();
        $.ajax({
            url: "{{ route('frontend.cart.update') }}",
            method: 'POST',
            data: {
                qty: qty,
                rand: rand
            },
            success: function (data) {
            loadingEnd();
                if (data.status) {
                    var timeouts;
                    $('#drop-cart').html(data.cartsmall);

                    $("#shopping_cart_wrapper").load(' #shopping_cart_content');

                    timeouts = setTimeout(function(){
                        subCheck();
                    }, 500);
                } else {
                    swal("Error", data.message, "error");
                    $('#drop-cart').load(' #cart_top_wrapper');
                    $("#shopping_cart_wrapper").load(' #shopping_cart_content');
                };
            }
        });
    }



    $("body").on('click', '#cart_remove_product', function (e) {
        e.preventDefault();
        loadingStart();

        var prods = [];
        $('.cart_product_check:checkbox:checked').each(function(){
            var $this = $(this);
            prods.push([ $this.data('rand') ]);
        });

        if (prods.length) {
            $.ajax({
                url: "{{ route('frontend.cart.multidelete') }}",
                method: 'POST',
                data: {
                    products: prods
                },
                success: function (data) {
                    loadingEnd();

                    if (data.status) {
                        $('#drop-cart').html(data.cartsmall);

                        $("#shopping_cart_wrapper").load(' #shopping_cart_content');
                    } else {
                        swal("Error", data.message, "error");
                        $('#drop-cart').load(' #cart_top_wrapper');
                        $("#shopping_cart_wrapper").load(' #shopping_cart_content');
                    };
                }
            });
        }


    });

    $("body").on('click', '.btn-wishlist, .btn-wish-prod', function (e) {
        var id      = $(this).data('id');
        $this       = $(this);
        loadingStart();
        $.ajax({
            url: "{{ route('frontend.user.wishlist.set') }}",
            method: 'POST',
            data: {
                id: id,
            },
            success: function (data) {
            loadingEnd();

                if (data.status) {
                    if (data.wishlist == 1) {
                        $this.addClass("active");
                    } else {
                        $this.removeClass("active");
                    }
                    swal("Success", data.message, "success");

                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    $("body").on('click', '.remove_wishlist', function (e) {
        var id      = $(this).data('id');
        $this = $(this);


        $.ajax({
            // url: "{{ route('frontend.user.wishlist.set') }}",
            method: 'POST',
            data: {
                id: id,
                reload: 1
            },
            success: function (data) {

                if (data.status) {
                    location.reload()
                } else {
                    swal("Error", data.message, "error");
                };
            }
        });
    });

    $('body').on('click', '#mark_read_all_header', function(e) {
        e.preventDefault();
        var url         = "{{ route('frontend.user.notification.mark_all_read') }}";
        $.ajax({
            type: 'POST',
            url: url,
            success: function success(data) {
                if (data.status) {
                    location.reload();
                } else {
                };
            }
        });
    });

    @endauth
    @guest

    $('body').on('click', '.add_to_cart, #add_to_cart_detail, .buynow_detail, .btn-wishlist, .btn-wish-prod , .add_to_cart_many, .notif_header', function(e) {
        e.preventDefault();
        window.location.href = "{{ route('frontend.login') }}";
    });
    @endguest
});
</script>
