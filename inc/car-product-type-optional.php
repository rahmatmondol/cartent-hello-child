<?php

if (!class_exists('WC_Product_optional_equipment')) {

    class WC_Product_optional_equipment extends WC_Product
    {

        public function __construct($product)
        {
            $this->product_type = 'optional_equipment';
            parent::__construct($product);
        }

        public function get_type()
        {
            return 'optional_equipment';
        }
    }
}

function add_your_product_type_optional($types)
{
    $types['optional_equipment'] = 'optional_equipment';
    return $types;
}

add_filter('product_type_selector', 'add_your_product_type_optional');

// car options
include_once('equipment-options/optional-pricing.php');

