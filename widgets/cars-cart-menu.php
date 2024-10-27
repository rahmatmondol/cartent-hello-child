<?php
class Elementor_hello_child_cars_cart_menu extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-cart-menu';
    }

    public function get_title()
    {
        return esc_html__('cars-cart-menu', 'elementor-addon');
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
        return ['cars-cart-menu'];
    }



    protected function render()
    {
        // Get the cart object
        $cart = WC()->cart;
        $item_count = $cart->get_cart_contents_count();

?>
        <div class="cart-menu">
            <ul class="cart">
                <li class="cart-item">
                    <a href="/cart"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/cart-icon.png" alt="cart-icon"></a>
                    <p id="product-cart"><?php echo $item_count > 0 ? $item_count : ''; ?></p>
                    <ul class="sub-menu">
                        <li><a href="/cart">My Cart</a></li>
                    </ul>
                </li>
                <li class="cart-item">
                    <a href="/my-account-2/"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/car-icon.png" alt="car"></a>
                    <p id="car-cart"></p>
                    <ul class="sub-menu">
                        <li> <a href="/my-account-2/">My Account</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <script>
            jQuery(document).ready(function($) {
                var wishlist = JSON.parse(localStorage.getItem('wish-list')) || [];
                if (wishlist.length > 0) {
                    $('#car-cart').text(wishlist.length);
                }
            });
        </script>

        <style>
            .cart-menu .cart li {
                list-style: none;
                cursor: pointer;
                display: flex;
                gap: 6px;
                position: relative;
                z-index: 10;
                padding: 0px;
            }

            .cart-item img {
                width: 30px;
            }

            .sub-menu {
                background: #eee;
                position: absolute;
                top: 30px;
                right: -12px;
                border-radius: 6px;
                z-index: 13;
                width: max-content;
                padding: 0;
                display: none;
            }

            .cart-menu .cart {
                margin: 0;
                padding: 0;
                display: flex;
                gap: 15px;
            }

            .cart-menu {
                width: 100px;
            }

            .cart-item p {
                margin: 0;
            }

            .sub-menu li a {
                color: #000;
            }

            .cart-menu .cart-item:hover .sub-menu {
                display: block;
            }

            .sub-menu li a {
                padding: 6px 24px;
            }
        </style>

<?php
    }
}
