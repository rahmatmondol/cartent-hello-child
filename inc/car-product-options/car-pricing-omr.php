<?php

// Add car priching tab
function add_car_pricing_omr_tab($tabs)
{
    $tabs['car_pricing_omr_tab'] = array(
        'label'    => __('Car pricing OMR', 'car'),
        'target'   => 'car_pricing_omr_tab',
        'priority' => 21,
        'class'    => array('show_if_car'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_car_pricing_omr_tab');


// Add custom fields to the custom tab for car rental product type
function car_pricing_custom_tab_content()
{
    global $post;

    echo '<div id="car_pricing_omr_tab" class="panel woocommerce_options_panel">';

    //per day
    woocommerce_wp_text_input(
        array(
            'id'          => '_per_day_omr',
            'label'       => __('Per Day (OMR)'),
            'placeholder' => __('Per Day'),
            'desc_tip'    => 'true',
            'description' => __('Per Day'),
            'value'       => get_post_meta($post->ID, '_per_day_omr', true),
        )
    );

    //per week
    woocommerce_wp_text_input(
        array(
            'id'          => '_per_week_omr',
            'label'       => __('Per week (OMR)'),
            'placeholder' => __('Per week'),
            'desc_tip'    => 'true',
            'description' => __('Per week'),
            'value'       => get_post_meta($post->ID, '_per_week_omr', true),
        )
    );

    //Insurance 
    woocommerce_wp_text_input(
        array(
            'id'          => '_insurance_per_day_omr',
            'label'       => __('Insurance Per Day (OMR)'),
            'placeholder' => __('Insurance Per Day'),
            'desc_tip'    => 'true',
            'description' => __('Insurance Per Day'),
            'value'       => get_post_meta($post->ID, '_insurance_per_day_omr', true),
        )
    );



    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'car_pricing_custom_tab_content');

// Save custom fields when the product is saved for car rental product type
function save_car_pricing_omr_tab_content($post_id)
{
    // Custom Field
    $per_day       = sanitize_text_field($_POST['_per_day_omr']);
    $per_week      = sanitize_text_field($_POST['_per_week_omr']);
    $insurance     = sanitize_text_field($_POST['_insurance_per_day_omr']);

    update_post_meta($post_id, '_per_day_omr', $per_day);
    update_post_meta($post_id, '_per_week_omr', $per_week);
    update_post_meta($post_id, '_insurance_per_day_omr', $insurance);
    update_post_meta($post_id, '_price', $per_day);
}

add_action('woocommerce_process_product_meta', 'save_car_pricing_omr_tab_content');
