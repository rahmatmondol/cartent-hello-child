<?php

// Add recovery_equipment priching tab
function add_optional_equipment_pricing_tab($tabs)
{
    $tabs['optional_equipment_pricing_tab'] = array(
        'label'    => __('pricing', 'optional_equipment'),
        'target'   => 'optional_equipment_pricing_tab',
        'priority' => 21,
        'class'    => array('show_if_optional_equipment'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_optional_equipment_pricing_tab');


// Add custom fields to the custom tab for recovery_equipment rental product type
function optional_equipment_pricing_tab()
{
    global $post;

    echo '<div id="optional_equipment_pricing_tab" class="panel woocommerce_options_panel">';

    //Installtaion
    woocommerce_wp_text_input(
        array(
            'id'          => 'installation_cost_omr',
            'label'       => __('Installtaion (OMR)'),
            'placeholder' => __('Installtaion Cost'),
            'desc_tip'    => 'true',
            'description' => __('Installtaion Cost in OMR'),
            'value'       => get_post_meta($post->ID, 'installation_cost_omr', true),
        )
    );

    //Installtaion
    woocommerce_wp_text_input(
        array(
            'id'          => 'installation_cost_aud',
            'label'       => __('Installtaion (AUD)'),
            'placeholder' => __('Installtaion Cost'),
            'desc_tip'    => 'true',
            'description' => __('Installtaion Cost in AUD'),
            'value'       => get_post_meta($post->ID, 'installation_cost_aud', true),
        )
    );

    //Installtaion
    woocommerce_wp_text_input(
        array(
            'id'          => 'per_day_omr',
            'label'       => __('Per Day (OMR)'),
            'placeholder' => __('Per Day Cost'),
            'desc_tip'    => 'true',
            'description' => __('Per Day Cost in OMR'),
            'value'       => get_post_meta($post->ID, 'per_day_omr', true),
        )
    );

    //Installtaion
    woocommerce_wp_text_input(
        array(
            'id'          => 'per_day_aud',
            'label'       => __('Per Day (AUD)'),
            'placeholder' => __('Per Day Cost'),
            'desc_tip'    => 'true',
            'description' => __('Per Day Cost in AUD'),
            'value'       => get_post_meta($post->ID, 'per_day_aud', true),
        )
    );


    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'optional_equipment_pricing_tab');

// Save custom fields when the product is saved for recovery_equipment rental product type
function save_optional_equipment_pricing_tab($post_id)
{
    // Custom Field
    $installation_omr  = sanitize_text_field($_POST['installation_cost_omr']);
    $installation_aud  = sanitize_text_field($_POST['installation_cost_aud']);
    $per_day_omr  = sanitize_text_field($_POST['per_day_omr']);
    $per_day_aud  = sanitize_text_field($_POST['per_day_aud']);

    update_post_meta($post_id, 'installation_cost_omr', $installation_omr);
    update_post_meta($post_id, 'installation_cost_aud', $installation_aud);
    update_post_meta($post_id, 'per_day_omr', $per_day_omr);
    update_post_meta($post_id, 'per_day_aud', $per_day_aud);
    update_post_meta($post_id, '_price', $per_day_omr);
}

add_action('woocommerce_process_product_meta', 'save_optional_equipment_pricing_tab');
