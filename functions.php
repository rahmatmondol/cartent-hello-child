<?php
function hello_child_enqueue_styles()
{
    $parent_style = 'Hello Elementor'; // Replace with the appropriate parent theme style handle

    // wp_enqueue_style($parent_style, get_template_directory_uri() . '/style.css');
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/style.css');

    wp_enqueue_script('main_script', get_stylesheet_directory_uri() . '/script.js', ['jquery'], false);
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js', ['jquery'], true);
}
add_action('wp_enqueue_scripts', 'hello_child_enqueue_styles');

function register_hello_child_cars($widgets_manager)
{

    require_once(__DIR__ . '/widgets/cars-home.php');
    require_once(__DIR__ . '/widgets/cars-choose.php');
    require_once(__DIR__ . '/widgets/cars-features.php');
    require_once(__DIR__ . '/widgets/cars-select-pickup-location.php');
    require_once(__DIR__ . '/widgets/cars-select-pickup-date-time.php');
    require_once(__DIR__ . '/widgets/cars-select-tent.php');
    require_once(__DIR__ . '/widgets/cars-select-equepment.php');
    require_once(__DIR__ . '/widgets/cars-rent-it-button.php');
    require_once(__DIR__ . '/widgets/cars-checkout-page.php');
    require_once(__DIR__ . '/widgets/cars-order-details-page.php');
    require_once(__DIR__ . '/widgets/cars-order-history.php');
    require_once(__DIR__ . '/widgets/cars-edit-my-account.php');
    require_once(__DIR__ . '/widgets/cars-wish-list.php');
    require_once(__DIR__ . '/widgets/cars-my-account.php');
    require_once(__DIR__ . '/widgets/cars-product-shop.php');
    require_once(__DIR__ . '/widgets/cars-product-wishlist.php');
    require_once(__DIR__ . '/widgets/cars-blog.php');
    require_once(__DIR__ . '/widgets/cars-cart-menu.php');

    $widgets_manager->register(new \Elementor_hello_child_cars_home());
    $widgets_manager->register(new \Elementor_hello_child_cars_choose());
    $widgets_manager->register(new \Elementor_hello_child_cars_features());
    $widgets_manager->register(new \Elementor_hello_child_cars_pickup_location());
    $widgets_manager->register(new \Elementor_hello_child_cars_pickup_date_time());
    $widgets_manager->register(new \Elementor_hello_child_cars_select_tent());
    $widgets_manager->register(new \Elementor_hello_child_cars_select_equepment());
    $widgets_manager->register(new \Elementor_hello_child_cars_rent_it_button());
    $widgets_manager->register(new \Elementor_hello_child_cars_checkout_page());
    $widgets_manager->register(new \Elementor_hello_child_cars_order_details_page());
    $widgets_manager->register(new \Elementor_hello_child_cars_order_history());
    $widgets_manager->register(new \Elementor_hello_child_cars_edit_my_account());
    $widgets_manager->register(new \Elementor_hello_child_cars_wish_list());
    $widgets_manager->register(new \Elementor_hello_child_cars_my_accout());
    $widgets_manager->register(new \Elementor_hello_child_cars_product_shop());
    $widgets_manager->register(new \Elementor_hello_child_cars_product_wishlist());
    $widgets_manager->register(new \Elementor_hello_child_cars_blog());
    $widgets_manager->register(new \Elementor_hello_child_cars_cart_menu());
}
add_action('elementor/widgets/register', 'register_hello_child_cars');

// check out page ajax request
include_once('inc/car-checkout-page-ajax.php');
include_once('inc/car-order-submition.php');
include_once('inc/car-order-history-ajax.php');
include_once('inc/car-edit-profile.php');
include_once('inc/car-wish-list-ajax.php');
include_once('inc/car-product-wishlist-ajax.php');
include_once('inc/add-to-cart-car.php');
include_once('inc/add-to-cart-product.php');

// all woocommerce functions
include_once('inc/woo-product-type-car.php');
include_once('inc/car-product-type-tent.php');
include_once('inc/car-product-type-optional.php');
include_once('inc/car-product-type-recovery.php');


function calculate_car_prices($cart)
{
    if (is_admin() && !defined('DOING_AJAX')) {
        return;
    }

    foreach ($cart->get_cart() as $cart_item) {
        $product = $cart_item['data'];

        //car calculate
        if ($product->is_type('car')) {
            $daily_price    = get_post_meta($product->get_id(), '_per_day_omr', true);
            $insurance      = get_post_meta($product->get_id(), '_insurance_per_day_omr', true);

            $total_days     = $cart_item['variation']['total_days'];
            $total_price    = $total_days * $daily_price;
            $total_price    += $total_days * $insurance;
            // Set the calculated price
            $cart_item['data']->set_price($total_price);
        }

        //tent calculate
        if ($product->is_type('tent')) {
            $total_days     = $cart_item['variation']['total_days'];
            $installation   = get_post_meta($product->get_id(), '_installation_cost_omr', true);
            if ($total_days > 20) {
                $total_price = $total_days * get_post_meta($product->get_id(), '_20days_omr', true);
            } elseif ($total_days > 11) {
                $total_price = $total_days * get_post_meta($product->get_id(), '_11days_omr', true);
            } else {
                $total_price = $total_days * get_post_meta($product->get_id(), '_10days_omr', true);
            }
            $total_price +=  $installation == '' ? 0 : $installation;
            // Set the calculated price
            $cart_item['data']->set_price($total_price);
        }

        //recovery calculate
        if ($product->is_type('recovery_equipment')) {
            $total_days = $cart_item['variation']['total_days'];
            $total_price =   $total_days * get_post_meta($product->get_id(), '_recovery_price_omr', true);
            // Set the calculated price
            $cart_item['data']->set_price($total_price);
        }

        //optional calculate
        if ($product->is_type('optional_equipment')) {
            $total_days     = $cart_item['variation']['total_days'];
            $installation   = get_post_meta($product->get_id(), 'installation_cost_omr', true);
            $per_day        = get_post_meta($product->get_id(), 'per_day_omr', true);
            $total_price    = $per_day == 'na' || $per_day == '' ? 0 : $per_day * $total_days;
            $total_price    = $installation == 'na' ||  $installation == '' ? $total_price : $total_price + $installation;
            // Set the calculated price
            $cart_item['data']->set_price($total_price);
        }
    }
}

add_action('woocommerce_before_calculate_totals', 'calculate_car_prices');


