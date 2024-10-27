<?php

// Add car priching tab
function add_car_free_km_tab($tabs)
{
    $tabs['car_free_km_tab'] = array(
        'label'    => __('Car Free Km', 'car'),
        'target'   => 'car_free_km_tab',
        'priority' => 21,
        'class'    => array('show_if_car'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_car_free_km_tab');


// Add custom fields to the custom tab for car rental product type
function car_free_km_tab_content()
{
    global $post;

    echo '<div id="car_free_km_tab" class="panel woocommerce_options_panel">';

    //free daye
    woocommerce_wp_text_input(
        array(
            'id'          => '_free_per_day',
            'label'       => __('Free KM Per day'),
            'placeholder' => __('Free KM Per day'),
            'desc_tip'    => 'true',
            'description' => __('Free KM Per day'),
            'value'       => get_post_meta($post->ID, '_free_per_day', true),
        )
    );

    //free week
    woocommerce_wp_text_input(
        array(
            'id'          => '_free_per_week',
            'label'       => __('Per week'),
            'placeholder' => __('Per week'),
            'desc_tip'    => 'true',
            'description' => __('Per week'),
            'value'       => get_post_meta($post->ID, '_free_per_week', true),
        )
    );

    //Additional Kms
    woocommerce_wp_text_input(
        array(
            'id'          => '_additional_kms',
            'label'       => __('Additional Kms '),
            'placeholder' => __('Additional Kms '),
            'desc_tip'    => 'true',
            'description' => __('Additional Kms '),
            'value'       => get_post_meta($post->ID, '_additional_kms', true),
        )
    );



    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'car_free_km_tab_content');

// Save custom fields when the product is saved for car rental product type
function save_car_free_km_tab_content($post_id)
{
    // Custom Field
    $per_day       = sanitize_text_field($_POST['_free_per_day']);
    $per_week      = sanitize_text_field($_POST['_free_per_week']);
    $additional     = sanitize_text_field($_POST['_additional_kms']);

    update_post_meta($post_id, '_free_per_day', $per_day);
    update_post_meta($post_id, '_free_per_week', $per_week);
    update_post_meta($post_id, '_additional_kms', $additional);
}

add_action('woocommerce_process_product_meta', 'save_car_free_km_tab_content');
