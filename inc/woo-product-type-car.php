<?php

if (!class_exists('WC_Product_car')) {

    class WC_Product_car extends WC_Product
    {

        public function __construct($product)
        {
            $this->product_type = 'car';
            parent::__construct($product);
        }

        public function get_type()
        {
            return 'car';
        }
    }
}

function add_your_product_type($types)
{
    $types['car'] = 'car';
    return $types;
}

add_filter('product_type_selector', 'add_your_product_type');

// car options
include_once('car-product-options/car-features.php');
include_once('car-product-options/car-pricing-omr.php');
include_once('car-product-options/car-pricing-aud.php');
include_once('car-product-options/car-free-km.php');
