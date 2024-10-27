<?php

// Add custom tab to the product data metabox for car rental product type
function add_car_rental_tab($tabs)
{
    $tabs['car_rental_tab'] = array(
        'label'    => __('Car Features ', 'car'),
        'target'   => 'car_rental_tab_data',
        'priority' => 21,
        'class'    => array('show_if_car'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_car_rental_tab');


// Add custom fields to the custom tab for car rental product type
function car_rental_custom_tab_content()
{
    global $post;

    $args = array(
        'post_type' => 'car',
        'posts_per_page' => -1,
    );
    $query = new WP_Query($args);


    echo '<div id="car_rental_tab_data" class="panel woocommerce_options_panel">';

    $terms = get_terms(array(
        'taxonomy' => 'car-type',
        'hide_empty' => false,
    ));
    $car_type = [];
    foreach ($terms as $type) {
        $car_type[$type->term_id] = $type->name;
    }

    // Select Vehicle Type
    woocommerce_wp_select(
        array(
            'id'          => '_vehicle_type',
            'label'       => __('Select Vehicle Type'),
            'placeholder' => __('Enter product link'),
            'desc_tip'    => 'true',
            'description' => __('Select Vehicle Type'),
            'value'       => get_post_meta($post->ID, '_vehicle_type', true),
            'options'     => $car_type,
        )
    );

    // Seats & Doors
    woocommerce_wp_text_input(
        array(
            'id'          => '_seat',
            'label'       => __('Seats & Doors'),
            'placeholder' => __('4 Door, 4 Seats'),
            'desc_tip'    => 'true',
            'description' => __('Seats & Doors'),
            'value'       => get_post_meta($post->ID, '_seat', true) == '' ? '4 Door, 4 Seats' : get_post_meta($post->ID, '_seat', true),
        )
    );

    // terms of trasmissions
    $terms = get_terms(array(
        'taxonomy' => 'transmission',
        'hide_empty' => false,
    ));
    $transmission = [];
    foreach ($terms as $term) {
        $transmission[$term->term_id] = $term->name;
    }
    //  Transmission
    woocommerce_wp_select(
        array(
            'id'          => '_transmission',
            'label'       => __('Select Transmission'),
            'placeholder' => __('Select Transmission'),
            'desc_tip'    => 'true',
            'description' => __('Select Transmission'),
            'value'       => get_post_meta($post->ID, '_transmission', true),
            'options'   => $transmission
        )
    );

    // Performance
    $terms = get_terms(array(
        'taxonomy' => 'performance',
        'hide_empty' => false,
    ));
    $performance = [];
    foreach ($terms as $term) {
        $performance[$term->term_id] = $term->name;
    }

    woocommerce_wp_select(
        array(
            'id'          => '_performance',
            'label'       => __('Off Road Performance'),
            'placeholder' => __('Off Road Performance'),
            'desc_tip'    => 'true',
            'description' => __('Select Off Road Performance'),
            'value'       => get_post_meta($post->ID, '_performance', true),
            'options'   => $performance
        )
    );

    // tent
    $terms = get_terms(array(
        'taxonomy' => 'tent-type',
        'hide_empty' => false,
    ));
    $tent = [];

    foreach ($terms as $term) {
        $tent[$term->term_id] = $term->name;
    }
    woocommerce_wp_select(
        array(
            'id'          => '_tent',
            'label'       => __('Select Roof top tent'),
            'placeholder' => __('Select Roof top tent'),
            'desc_tip'    => 'true',
            'description' => __('Select Roof top tent'),
            'value'       => get_post_meta($post->ID, '_tent', true),
            'options'   => $tent,
            // 'custom_attributes' => array('multiple' => 'multiple')
        )
    );

    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'car_rental_custom_tab_content');

// Save custom fields when the product is saved for car rental product type
function save_car_rental_custom_tab_content($post_id)
{
    // Custom Field
    $car_type       = sanitize_text_field($_POST['_vehicle_type']);
    $seat           = sanitize_text_field($_POST['_seat']);
    $transmission   = sanitize_text_field($_POST['_transmission']);
    $tent           = isset($_POST['_tent']) ? $_POST['_tent'] : '';
    $performance    = sanitize_text_field($_POST['_performance']);

    update_post_meta($post_id, '_vehicle_type', $car_type);
    update_post_meta($post_id, '_seat', $seat);
    update_post_meta($post_id, '_transmission', $transmission);
    update_post_meta($post_id, '_tent', $tent);
    update_post_meta($post_id, '_performance', $performance);
}

add_action('woocommerce_process_product_meta', 'save_car_rental_custom_tab_content');
