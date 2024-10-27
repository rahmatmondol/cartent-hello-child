<?php

add_action('wp_ajax_product_add_to_cart', 'product_add_cart_event');
add_action('wp_ajax_nopriv_product_add_to_cart', 'product_add_cart_event');

function product_add_cart_event()
{

    $product_id     = isset($_POST['id']) ? $_POST['id'] : '';
    $size_id        = isset($_POST['size']) ? $_POST['size'] : '';
    $qty            = isset($_POST['qty']) ? $_POST['qty'] : '';

    //add cart car
    $result = WC()->cart->add_to_cart($size_id,  $qty, [], []);

    echo json_encode($result);

    exit;
}
