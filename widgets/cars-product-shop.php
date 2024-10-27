<?php
class Elementor_hello_child_cars_product_shop extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-product-shop';
    }

    public function get_title()
    {
        return esc_html__('cars-product-shop', 'elementor-addon');
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
        return ['cars-product-shop'];
    }

    protected function register_controls()
    {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Per page product', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Per page product', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => esc_html__('3', 'elementor-addon'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type' => 'product',
            'posts_per_page' => $settings['per_page'],
        );
        $query = new WP_Query($args);

        $args = array(
            'post_type'         => 'product',
            'posts_per_page' => -1,
            'type' => 'variable',
            'post_status' => 'publish',
        );

        $query = new WC_Product_Query($args);
        $products = $query->get_products();

        $display_prices_including_tax = get_option('woocommerce_tax_display_shop');

        echo '<pre>';
        print_r($display_prices_including_tax);
        echo '</pre>';

?>


        <?php if ($products) : ?>
            <div class="conteiner">
                <div class="row">
                    <?php foreach ($products as $product) : ?>
                        <div class="col-lg-4">
                            <img class="car-image" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'large') ?>" alt="<?php echo $product->get_name(); ?>">
                            <div class="price-box">
                                <p>
                                    <?php echo $product->get_name(); ?>
                                </p>
                                <p>
                                    <?php
                                    $sizes = get_children(array(
                                        'post_parent' => $product->get_id(),
                                        'post_type'   => 'product_variation',
                                    ));
                                    ?>
                                    <?php foreach ($sizes as $size) {
                                    }
                                    echo get_post_meta($size->ID, '_price', true); ?>

                                </p>
                            </div>

                            <div class="options">
                                <div class="size">
                                    <select class="form-select size" name="size" data-id="<?php echo $product->get_id(); ?>" aria-label="Default select example">
                                        <option selected>Select Size</option>
                                        <?php foreach ($sizes as $size) : $result = str_replace($product->name . ' - ', "", $size->post_title); ?>
                                            <option value="<?php echo $size->ID; ?>"><?php echo $result; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="quantity">
                                    <select class="form-select quantity" name="qty" data-id="<?php echo $product->get_id(); ?>" aria-label="Default select example">
                                        <option selected value="0">Select Quantity</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="description">
                                <p><?php echo $product->get_description(); ?></p>
                            </div>
                            <div class="action-button">
                                <div>
                                    <a class="add-to-cart" id="cart-<?php echo $product->get_id(); ?>" data-qty="" data-size="" data-id="<?php echo $product->get_id(); ?>">Add to Cart <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CART-ICON.png" alt=""></a>
                                </div>
                                <div>
                                    <p class="favourite" id="favourite-<?php echo $product->get_id(); ?>" data-id="<?php echo $product->get_id(); ?>">Add to Favourite <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/heart icon.png" alt=""></p>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="error-wraper">
                    <div class="error-popup-box">
                        <div class="error-massage">
                            <p class="error">massage</p>
                            <span class="close-button">ok</span>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <script>
            jQuery(document).ready(function($) {

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

                $('.favourite').click(function() {
                    var id = $(this).data('id');
                    old_wishlist = JSON.parse(localStorage.getItem('product-wishlist')) || [];
                    old = old_wishlist.filter(function(item) {
                        if (item == id) {
                            return true;
                        }
                    });

                    if (old.length == 0) {
                        old_wishlist.push(id);
                        localStorage.setItem('product-wishlist', JSON.stringify(old_wishlist));
                        $(this).text('Added In Wishlist')
                    }
                });
                //all poup close
                $('.error-popup-box').click(function() {
                    $('.error-wraper').hide();
                })

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
                border-radius: 42px !important;
                width: 90%;
                margin-bottom: 20px;
                height: 450px !important;
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
                gap: 20px;
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
