<?php

// Add tent priching tab
function add_tent_pricing_omr_tab($tabs)
{
    $tabs['tent_pricing_omr_tab'] = array(
        'label'    => __('tent pricing OMR', 'tent'),
        'target'   => 'tent_pricing_omr_tab',
        'priority' => 1,
        'class'    => array('show_if_tent'),
    );
    return $tabs;
}

add_filter('woocommerce_product_data_tabs', 'add_tent_pricing_omr_tab');


// Add custom fields to the custom tab for tent rental product type
function tent_pricing_custom_tab_content()
{
    global $post;

    echo '<div id="tent_pricing_omr_tab" class="panel woocommerce_options_panel">';
   
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
            'id'          => '_tent_type',
            'label'       => __('Select Tent Type'),
            'placeholder' => __('Select Tent Type'),
            'desc_tip'    => 'true',
            'description' => __('Select Tent Type'),
            'value'       => get_post_meta($post->ID, '_tent_type', true),
            'options'   => $tent,
        )
    );

    //Instalation Const
    woocommerce_wp_text_input(
        array(
            'id'          => '_installation_cost_omr',
            'label'       => __('Instalation Const (OMR)'),
            'placeholder' => __('Instalation Const'),
            'desc_tip'    => 'true',
            'description' => __('Instalation Const'),
            'value'       => get_post_meta($post->ID, '_installation_cost_omr', true),
        )
    );

    //First 10 days
    woocommerce_wp_text_input(
        array(
            'id'          => '_10days_omr',
            'label'       => __('First 10 days (OMR)'),
            'placeholder' => __('First 10 days'),
            'desc_tip'    => 'true',
            'description' => __('First 10 days'),
            'value'       => get_post_meta($post->ID, '_10days_omr', true),
        )
    );

    //11 + days
    woocommerce_wp_text_input(
        array(
            'id'          => '_11days_omr',
            'label'       => __('11 + days (OMR)'),
            'placeholder' => __('11 + days'),
            'desc_tip'    => 'true',
            'description' => __('11 + days'),
            'value'       => get_post_meta($post->ID, '_11days_omr', true),
        )
    );

    //20 + days
    woocommerce_wp_text_input(
        array(
            'id'          => '_20days_omr',
            'label'       => __('20 + days (OMR)'),
            'placeholder' => __('20 + days'),
            'desc_tip'    => 'true',
            'description' => __('20 + days'),
            'value'       => get_post_meta($post->ID, '_20days_omr', true),
        )
    );

   

    echo '</div>';
}

add_action('woocommerce_product_data_panels', 'tent_pricing_custom_tab_content');

// Save custom fields when the product is saved for tent rental product type
function save_tent_pricing_omr_tab_content($post_id)
{
    // Custom Field
    $tent_type      = sanitize_text_field($_POST['_tent_type']);
    $installation   = sanitize_text_field($_POST['_installation_cost_omr']);
    $ten_days       = sanitize_text_field($_POST['_10days_omr']);
    $eleven_days    = sanitize_text_field($_POST['_11days_omr']);
    $twenty_days    = sanitize_text_field($_POST['_20days_omr']);

    update_post_meta($post_id, '_tent_type', $tent_type);
    update_post_meta($post_id, '_installation_cost_omr', $installation);
    update_post_meta($post_id, '_10days_omr', $ten_days);
    update_post_meta($post_id, '_11days_omr', $eleven_days);
    update_post_meta($post_id, '_20days_omr', $twenty_days);
    // update_post_meta($post_id, '_price', $ten_days, true);
}

add_action('woocommerce_process_product_meta', 'save_tent_pricing_omr_tab_content');
