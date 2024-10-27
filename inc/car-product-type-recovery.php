<?php

if (!class_exists('WC_Product_recovery_equipment')) {

    class WC_Product_recovery_equipment extends WC_Product
    {

        public function __construct($product)
        {
            $this->product_type = 'recovery_equipment';
            parent::__construct($product);
        }

        public function get_type()
        {
            return 'recovery_equipment';
        }
    }
}

function add_your_product_type_recovery($types)
{
    $types['recovery_equipment'] = 'recovery_equipment';
    return $types;
}

add_filter('product_type_selector', 'add_your_product_type_recovery');

// car options
include_once('equipment-options/recovery-pricing.php');

