<?php
class Elementor_hello_child_cars_product_wishlist extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-product-wishlist';
    }

    public function get_title()
    {
        return esc_html__('cars-product-wishlist', 'elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['cars-product-wishlist'];
    }

    protected function render()
    {

?>
        <div class="conteiner">
            <div class="row">
                <h2 class="page-title">Shopping List</h2>
            </div>
            <div class="row" id="product-lists">

            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                var url = '<?php echo admin_url('admin-ajax.php'); ?>';
                var ids = JSON.parse(localStorage.getItem('product-wishlist')) || [];
                $.ajax({
                    url: url,
                    method: 'get',
                    // dataType: 'json',
                    data: {
                        action: 'get_products_product_wishlist',
                        ids
                    },
                    success: function(response) {
                        $('#product-lists').html(response);
                        afterajax();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

                function afterajax() {
                    var wishlist = JSON.parse(localStorage.getItem('product-wishlist')) || [];
                    if (wishlist.length > 0) {
                        wishlist.filter(function(item) {
                            var selector = '#favourite-' + item;
                            $(selector).text('Added In Wishlist');
                        });
                    }

                    $('.size').change(function() {
                        var id = $(this).data('id');
                        var value = $(this).val();
                        var selector = '#cart-' + id;
                        if (id !== undefined) {
                            $(selector).data('size', value);
                            $(selector).data('qty', 0);
                            $('.quantity').val(0);
                            $(selector).removeAttr('href');
                        }
                    });

                    $('.quantity').change(function() {
                        var id = $(this).data('id');
                        var value = $(this).val();
                        var selector = '#cart-' + id;
                        var product = $(selector).data('size');
                        if (id !== undefined) {
                            $(selector).data('qty', value);
                            $(selector).attr('href', '/cart/?add-to-cart=' + product + '&quantity=' + value);
                        }
                    });

                    $('.add-to-cart').click(function() {
                        var id = $(this).data('id');
                        var size = $(this).data('size');
                        var qty = $(this).data('qty');

                        if (size == '') {
                            $('.error').text('Please select Size');
                            $('.error-wraper').show();
                        } else if (qty == '') {
                            $('.error').text('Please select Quantity');
                            $('.error-wraper').show();
                        }
                    });


                    //all poup close
                    $('.error-popup-box').click(function() {
                        $('.error-wraper').hide();
                    })
                }

            });
        </script>


        <style>
            .error-wraper {
                display: none;
            }

            .error-popup-box {
                width: 100vw;
                position: fixed;
                height: 100vh;
                background: #0000007d;
                text-align: center;
                top: 0px;
                left: 0;
                z-index: 110;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .error-massage {
                background: #fff;
                width: 400px;
                height: 270px;
                border-radius: 20px;
                padding: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }

            .error-massage .error {
                font-size: 25px;
            }

            .error-massage .close-button {
                position: absolute;
                bottom: 15px;
                right: 15px;
                font-size: 20px;
                color: #08a0b9;
                cursor: pointer;
            }

            .pupup-close-box.active {
                --bs-backdrop-zindex: 1050;
                --bs-backdrop-opacity: 0.5;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 100;
                width: 100vw;
                height: 100vh;
                background-color: var(--bs-backdrop-bg);
            }

            .add-to-cart.active {
                background: #0372e8 !important;
            }

            .description {
                width: 90%;
                margin-top: 15px;
            }

            .options {
                width: 90%;
                display: flex;
                flex-flow: column;
                gap: 10px;
                margin-top: 10px;
            }

            .options select {
                height: 48px;
                border-radius: 0;
                font-size: 17px;
            }

            .price-box {
                display: flex;
                gap: 20px;
            }

            .price-box p {
                margin: 0;
                text-transform: uppercase;
                font-size: 18px;
            }

            .action-button .favourite {
                width: 180px;
                padding: 10px 10px;
                color: #575757;
                border: 2px solid #c6c6c6;
                border-radius: 10px;
                position: relative;
                display: inline-block;
                cursor: pointer;
            }

            .action-button img {
                width: 20px;
                position: absolute;
                top: 15px;
                right: 15px;
            }


            .line {
                width: 200px;
                height: 2px;
                background-color: #000 !important;
            }

            .featurs {
                margin-bottom: 10px;
            }

            .details-price {
                margin-top: 10px;
            }

            .title {
                font-size: 22px;
                color: #333;
            }

            .car-image {
                box-shadow: -2px 5px 7px 0px rgba(0, 0, 0, 0.16) !important;
                border-radius: 30px !important;
                width: 90%;
                margin-bottom: 20px;
                height: 300px !important;
            }

            .chose-car-feature {
                padding: 0;
            }

            .chose-car-feature .feature-list {
                list-style: none;
                padding: 5px 0px;
                font-size: 16px;
            }

            .chose-car-feature .feature-list img {
                width: 30px;
                margin-right: 15px;

            }

            .action-button .add-to-cart {
                background-color: #4f4f4f;
                text-align: left;
                color: #fff !important;
                border-radius: 10px;
                font-size: 18px;
                position: relative;
                width: 180px;
                display: inline-block;
                padding: 10px 15px;
                cursor: pointer;
                margin: 0;
            }

            .action-button .add-to-wish-list {
                text-align: center;
                border: 1px solid #848484;
                border-radius: 10px;
                color: #464646;
                padding: 10px 28px;
                font-size: 18px;
            }

            .action-button .add-to-wish-list:hover {
                background: #fff;
            }

            .action-button {
                display: flex;
                flex-flow: column;
                gap: 30px;
                margin: 30px 0px;
            }

            .page-title {
                margin-bottom: 40px;
                font-size: 25px;
            }

            .brath {
                display: flex;
                justify-content: start;
                align-items: center;
                margin: 40px 0px;
            }

            .brath img {
                width: 55px;
                height: fit-content;
            }

            .brath h2 {
                font-size: 34px;
            }
        </style>

<?php
    }
}
