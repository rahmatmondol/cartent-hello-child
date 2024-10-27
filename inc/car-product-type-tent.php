<?php

if (!class_exists('WC_Product_tent')) {

    class WC_Product_tent extends WC_Product
    {

        public function __construct($product)
        {
            $this->product_type = 'tent';
            parent::__construct($product);
        }

        public function get_type()
        {
            return 'tent';
        }
    }
}

function add_your_product_type_tent($types)
{
    $types['tent'] = 'tent';
    return $types;
}

add_filter('product_type_selector', 'add_your_product_type_tent');

// car options
include_once('tent-options/tent-pricing-omr.php');
include_once('tent-options/tent-pricing-aud.php');

