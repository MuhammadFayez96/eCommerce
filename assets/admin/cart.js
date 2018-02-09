$(document).ready(function () {

    'use strict';
    var shoppingCartBox = $('#shopping-cart-box');
    $('.number-up').on('click', function (e) {
        e.preventDefault();
        $(this).prop('disabled', true);

        var $value = ($(this).closest('.cat-number').find('input[type="text"]').attr('value'));
        $(this).closest('.cat-number').find('input[type="text"]').attr('value', parseFloat($value) + 1);

        var shoppingCartBox = $('#shopping-cart-box');
        var cartIndex = $('.cart-index');
        // cartIndex.LoadingOverlay("show");
        $.ajax({
            url: $(this).data('url'),
            data: {quantity: 1, _token: $(this).data('csrf')},
            method: 'post',
            success: function (data) {
                shoppingCartBox.html(data.views.cart_view);
                // cartIndex.html(data.views.cart_index_view).LoadingOverlay("hide", true);
                cartIndex.html(data.views.cart_index_view);
                $(this).prop('disabled', false);
                // $.ajax({
                //     url: shoppingCartBox.data('url'),
                //     success: function (data) {
                //         shoppingCartBox.html(data.cart_view);
                //         cartIndex.html(data.cart_index_view);
                //         $(this).prop('disabled', false);
                //     },
                //     error: function () {
                //         alert('Internal Server Error.');
                //     }
                // });
                /*noty({
                 text: data.msg,
                 type: data.status,
                 timeout: 3000,
                 closeWith: ['click'],
                 maxVisible: 5,
                 animation: {
                 open: 'animated bounceInLeft',
                 close: 'animated bounceOutLeft',
                 easing: 'swing',
                 speed: 500 // opening & closing animation speed
                 },
                 });*/
            },
            error: function () {
                console.log('add error');
                noty({
                    text: 'Internal Server Error',
                    type: 'error',
                    tiemout: 3000,
                    animation: {
                        open: 'animated bounceInLeft',
                        close: 'animated bounceOutLeft',
                        easing: 'swing',
                        speed: 500 // opening & closing animation speed
                    }
                });
            }
        })
        ;
        //            return false;
    })
    ;

    $('.number-down').on('click', function () {
        var $value = ($(this).closest('.cat-number').find('input[type="text"]').attr('value'));
        if ($value > 1) {
            $(this).closest('.cat-number').find('input[type="text"]').attr('value', parseFloat($value) - 1);
        }
        var shoppingCartBox = $('#shopping-cart-box');
        var cartIndex = $('.cart-index');
        cartIndex.LoadingOverlay("show");
        $.ajax({
            url: $(this).data('url'),
            data: {quantity: -1, _token: $(this).data('csrf')},
            method: 'post',
            success: function (data) {
                shoppingCartBox.html(data.views.cart_view);
                cartIndex.html(data.views.cart_index_view).LoadingOverlay("hide", true);
                $(".head-cart-items").owlCarousel({
                    items: 3,
                    itemsDesktopSmall: [979, 2],
                    itemsDesktop: [1199, 2],
                    navigation: true,
                    pagination: false,
                    autoPlay: true,
                    navigationText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
                });
                $(this).prop('disabled', false);
                // $.ajax({
                //     url: shoppingCartBox.data('url'),
                //     success: function (data) {
                //         shoppingCartBox.html(data.cart_view);
                //         cartIndex.html(data.cart_index_view);
                //     },
                //     error: function () {
                //         alert('Internal Server Error.');
                //     }
                // });
                /*noty({
                 text: data.msg,
                 type: data.status,
                 timeout: 3000,
                 closeWith: ['click'],
                 maxVisible: 5,
                 animation: {
                 open: 'animated bounceInLeft',
                 close: 'animated bounceOutLeft',
                 easing: 'swing',
                 speed: 500 // opening & closing animation speed
                 },
                 });*/
            },
            error: function () {
                console.log('add error');
                noty({
                    text: 'Internal Server Error',
                    type: 'error',
                    tiemout: 3000,
                    animation: {
                        open: 'animated bounceInLeft',
                        close: 'animated bounceOutLeft',
                        easing: 'swing',
                        speed: 1000 // opening & closing animation speed
                    }
                });
            }
        })
//            return false;
    });

})
;