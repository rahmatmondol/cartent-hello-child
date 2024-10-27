<?php

// Add recovery_equipment priching tab
function add_recovery_equipment_pricing_tab($tabs)
{
    $tabs['recovery_equipment_pricing_omr_tab'] = array(
        'label'    => __('pricing', 'recovery_equipment'),
        'target'   => 'recovery_equipment_pricing_omr_tab',
        'priority' => 21,
        'class'    => array('show_if_recovery_equipment'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_recovery_equipment_pricing_tab');


// Add custom fields to the custom tab for recovery_equipment rental product type
function recovery_equipment_pricing_tab()
{
    global $post;

    echo '<div id="recovery_equipment_pricing_omr_tab" class="panel woocommerce_options_panel">';

    //Price
    woocommerce_wp_text_input(
        array(
            'id'          => '_recovery_price_omr',
            'label'       => __('Price (OMR)'),
            'placeholder' => __('Price'),
            'desc_tip'    => 'true',
            'description' => __('Price'),
            'value'       => get_post_meta($post->ID, '_recovery_price_omr', true),
        )
    );

    //Price
    woocommerce_wp_text_input(
        array(
            'id'          => '_recovery_price_aud',
            'label'       => __('Price (aud)'),
            'placeholder' => __('Price'),
            'desc_tip'    => 'true',
            'description' => __('Price'),
            'value'       => get_post_meta($post->ID, '_recovery_price_aud', true),
        )
    );

    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'recovery_equipment_pricing_tab');

// Save custom fields when the product is saved for recovery_equipment rental product type
function save_recovery_equipment_pricing($post_id)
{
    // Custom Field
    $price_omr  = sanitize_text_field($_POST['_recovery_price_omr']);
    $price_aud  = sanitize_text_field($_POST['_recovery_price_aud']);

    update_post_meta($post_id, '_recovery_price_omr', $price_omr);
    update_post_meta($post_id, '_recovery_price_aud', $price_aud);
    update_post_meta($post_id, '_price', $price_omr);
}

add_action('woocommerce_process_product_meta', 'save_recovery_equipment_pricing');
