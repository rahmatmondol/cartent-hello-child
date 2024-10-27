<?php

add_action('wp_ajax_car_add_to_cart', 'car_add_cart_event');
add_action('wp_ajax_nopriv_car_add_to_cart', 'car_add_cart_event');

function car_add_cart_event()
{

    $recoverys      = isset($_POST['add_ons_recovery']) ? $_POST['add_ons_recovery'] : '';
    $optionals      = isset($_POST['add_ons_optional']) ? $_POST['add_ons_optional'] : '';
    $car_id         = isset($_POST['car_id']) ? $_POST['car_id'] : '';
    $tent_id        = isset($_POST['tent_id']) ? $_POST['tent_id'] : '';
    $location_id    = isset($_POST['location_id']) ? $_POST['location_id'] : '';
    $pick_up_date   = isset($_POST['pick_up_date']) ? $_POST['pick_up_date'] : '';
    $pick_up_time   = isset($_POST['pick_up_time']) ? $_POST['pick_up_time'] : '';
    $return_date    = isset($_POST['return_date']) ? $_POST['return_date'] : '';
    $return_time    = isset($_POST['return_time']) ? $_POST['return_time'] : '';
    $total_days     = isset($_POST['total_days']) ? $_POST['total_days'] : '';

    //add cart car
    WC()->cart->add_to_cart($car_id, 1, [], [
        'total_days'  => $total_days,
        'pickup_date' => $pick_up_date,
        'pickup_time' => $pick_up_time,
        'return_date' => $return_date,
        'return_time' => $return_time,
        'location'    => get_the_title($location_id),
        'is_car'      => true
    ]);
 
    // add cart recovery equivalent
    foreach ($recoverys as $recovery) {
        WC()->cart->add_to_cart($recovery, 1, [], [
            'total_days' => $total_days,
            'is_recovery'   => true
        ]);
    }

    // add cart optional equivalent
    foreach ($optionals as $optional) {
        WC()->cart->add_to_cart($optional, 1, [], [
            'total_days' => $total_days,
            'is_optional'   => true
        ]);
    }

    //add tent
    WC()->cart->add_to_cart($tent_id, 1, [], [
        'total_days' => $total_days,
        'is_tent'   => true
    ]);

    echo json_encode(true);

    exit;
}
