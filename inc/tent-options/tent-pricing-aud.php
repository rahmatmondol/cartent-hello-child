<?php

// Add tent priching tab
function add_tent_pricing_aud_tab($tabs)
{
    $tabs['tent_pricing_aud_tab'] = array(
        'label'    => __('tent pricing aud', 'tent'),
        'target'   => 'tent_pricing_aud_tab',
        'priority' => 21,
        'class'    => array('show_if_tent'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_tent_pricing_aud_tab');


// Add custom fields to the custom tab for tent rental product type
function tent_pricing_aud_tab_content()
{
    global $post;

    echo '<div id="tent_pricing_aud_tab" class="panel woocommerce_options_panel">';

    //Instalation Const
    woocommerce_wp_text_input(
        array(
            'id'          => '_installation_cost_aud',
            'label'       => __('Instalation Const (AUD)'),
            'placeholder' => __('Instalation Const'),
            'desc_tip'    => 'true',
            'description' => __('Instalation Const'),
            'value'       => get_post_meta($post->ID, '_installation_cost_aud', true),
        )
    );

    //First 10 days
    woocommerce_wp_text_input(
        array(
            'id'          => '_10days_aud',
            'label'       => __('First 10 days (AUD)'),
            'placeholder' => __('First 10 days'),
            'desc_tip'    => 'true',
            'description' => __('First 10 days'),
            'value'       => get_post_meta($post->ID, '_10days_aud', true),
        )
    );

    //11 + days
    woocommerce_wp_text_input(
        array(
            'id'          => '_11days_aud',
            'label'       => __('11 + days (AUD)'),
            'placeholder' => __('11 + days'),
            'desc_tip'    => 'true',
            'description' => __('11 + days'),
            'value'       => get_post_meta($post->ID, '_11days_aud', true),
        )
    );

    //20 + days
    woocommerce_wp_text_input(
        array(
            'id'          => '_20days_aud',
            'label'       => __('20 + days (AUD)'),
            'placeholder' => __('20 + days'),
            'desc_tip'    => 'true',
            'description' => __('20 + days'),
            'value'       => get_post_meta($post->ID, '_20days_aud', true),
        )
    );



    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'tent_pricing_aud_tab_content');

// Save custom fields when the product is saved for tent rental product type
function save_tent_pricing_aud_tab_content($post_id)
{
    // Custom Field
    $installation  = sanitize_text_field($_POST['_installation_cost_aud']);
    $ten_days      = sanitize_text_field($_POST['_10days_aud']);
    $eleven_days   = sanitize_text_field($_POST['_11days_aud']);
    $twenty_days   = sanitize_text_field($_POST['_20days_aud']);

    update_post_meta($post_id, '_installation_cost_aud', $installation);
    update_post_meta($post_id, '_10days_aud', $ten_days);
    update_post_meta($post_id, '_11days_aud', $eleven_days);
    update_post_meta($post_id, '_20days_aud', $twenty_days);
}

add_action('woocommerce_process_product_meta', 'save_tent_pricing_aud_tab_content');
