(function ($) {
  /*  $(window).on('load', function() {
        console.log('load');
        console.log($('body.logged-in').length);
        console.log($('body.woocommerce-page').length );
        console.log( $('body .product_list_widget').length);
        if ($('body.logged-in').length  || $('body.woocommerce-page').length || $('body .product_list_widget').length ){
            console.log('show');
        } else {
            console.log('hide');
            $('.header-add-links .only-shop').hide();
        }
    });

    window.addEventListener("load", (event) => {
        console.log("page is fully loaded");
    });*/

    $(document).ready(function(){
        //update mini-cart change input qty
        $('.minicart-wrapper').on( 'change', '.qty', function() {
            var $thisbutton = $(this);

            var item_hash = $(this).closest('.woocommerce-mini-cart-item').find('.remove_from_cart_button').attr( 'data-cart_item_key' );
            var item_quantity = $( this ).val();
            var currentVal = parseFloat(item_quantity);

            $.ajax({
                type: 'POST',
                url: cart_qty_ajax.ajax_url,
                data: {
                    action: 'my_cart_qty',
                    hash: item_hash,
                    quantity: currentVal
                },
                beforeSend: function () {
                    $('.widget_shopping_cart_content').addClass( 'loader' ).block( {
                        message: null,
                        overlayCSS: {
                            background: '#000',
                            opacity: 0.6
                        }
                    } );
                },
                complete: function () {
                    $('.widget_shopping_cart_content').removeClass( 'loader' );
                    jQuery(document.body).trigger('wc_fragment_refresh');
                },
                success: function(response) {
                    jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                    //jQuery(document.body).trigger('update_checkout');
                }
            });

        });

        $('.minicart-wrapper ').on( 'click', '.plus, .minuse', function() {
            var qty = $(this).closest('.quantity').find('.qty');
            var val = parseFloat(qty.val());
            var max = parseFloat(qty.attr( 'max' ));
            var min = parseFloat(qty.attr( 'min' ));
            var step = parseFloat(qty.attr( 'step' ));

            if ( $( this ).is( '.plus' ) ) {
                if ( max && ( max <= val ) ) {
                    qty.attr('value', max);
                } else {
                    qty.attr('value', val + step);
                }
            } else {
            /*  if ( min && ( min >= val ) ) {
                    qty.attr('value', min);
                } else if ( val > 1 ) {
                    qty.attr('value', val - step);
                } */

                if ( min && ( min >= val ) ) {
                    qty.attr('value', min);
                } else {
                    qty.attr('value', val - step);
                }
            }

            if (val < 1) {
                $(this).closest('li').find('.remove_from_cart_button').click();
            } else {
                var $thisbutton = $(this).closest('.quantity').find('.qty');
                var item = $(this).closest('.woocommerce-mini-cart-item');
                var item_hash = item.find('.remove_from_cart_button').attr( 'data-cart_item_key' );
                var item_quantity = parseFloat($thisbutton.val());

                $.ajax({
                    type: 'POST',
                    url: cart_qty_ajax.ajax_url,
                    data: {
                        action: 'my_cart_qty',
                        hash: item_hash,
                        quantity: item_quantity
                    },
                    beforeSend: function () {
                        $('.widget_shopping_cart_content').addClass( 'loader' ).block( {
                            message: null,
                            overlayCSS: {
                                background: '#000',
                                opacity: 0.6
                            }
                        } );
                    },
                    complete: function () {
                        $('.widget_shopping_cart_content').removeClass( 'loader' );
                        jQuery(document.body).trigger('wc_fragment_refresh');
                    },
                    success: function(response) {
                        var fragments = response.fragments;
                        if ( fragments ) {
                            jQuery.each(fragments, function(key, value) {
                                jQuery(key).replaceWith(value);
                            });
                        }

                        //jQuery(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
                        //$('.minicart-wrapper').html(response);
                        //jQuery(document.body).trigger('wc_fragment_refresh');
                        //$(document.body).trigger('wc_fragments_loaded');
                    }
                });
            }
        });

        $('.woocommerce-form-coupon, woocommerce-cart-form').on('click', '.wp-element-button', function(){
            setTimeout(function(){
                jQuery(document.body).trigger('wc_fragment_refresh');
            }, 1500);
        });

        $('.woocommerce').on('click', 'a.btn_remove', function(){
            setTimeout(function(){
                jQuery(document.body).trigger('wc_fragment_refresh');
            }, 2000);
        });

        $('.woocommerce-checkout, .woocommerce-cart').on('click', '.cart-link', function() {
            setTimeout(function () {
                jQuery(document.body).trigger('wc_fragment_refresh');
            }, 500);
        });

        if ($('.header-add-links .only-shop').length) {
            setTimeout(function(){
                if ($('body.logged-in').length || $('body.woocommerce-page').length || $('body .product_list_widget').length) {
                    console.log('show');
                    $('.header-add-links .only-shop').show();
                } else {
                    console.log('hide');
                }
            }, 100);
        }
    });
})(jQuery);
