<?php

add_action('admin_post_order_submit_handaller', 'order_submit_handaller');
add_action('admin_post_nopriv_order_submit_handaller', 'order_submit_handaller');

function order_submit_handaller()
{

    if (isset($_POST['action']) && $_POST['action'] == 'order_submit_handaller') {
        $fist_name      = sanitize_text_field($_POST['first-name']);
        $last_name      = sanitize_text_field($_POST['last-name']);
        $email          = sanitize_email($_POST['email']);
        $contact_number = sanitize_text_field($_POST['contact-number']);
        $above_22       = isset($_POST['above-22']) ? 1 : 0;

        $user_id = get_current_user_id();

        if (!$user_id) {
            $new_user_data = array(
                'user_login'    => $fist_name,
                'user_pass'     => 12345678,
                'user_email'    =>  $email,
                'display_name'  =>  $fist_name,
                'first_name'    => $fist_name,
                'last_name'     => $last_name,
            );
            // Create new user
            $user_id = wp_insert_user($new_user_data);
            //asign role to car_user
            $user = new WP_User($user_id);
            $user->set_role('customer');
            $login_data = array(
                'user_login'    => $email,
                'user_password' => 12345678,
                'remember'      => true,
            );
            wp_signon($login_data);
        }

        update_user_meta($user_id, 'contact_number',  $contact_number);

        // $cart_item_key = WC()->cart->add_to_cart($car_id, 1, [], [
        //     'total_days' => $total_days
        // ]);


        // if ($cart_item_key) {
        //     $cart_url = wc_get_cart_url(); // Get the cart URL
        //     wp_redirect($cart_url); // Redirect to the cart page
        //     exit;
        // } else {
        //     // Handle the case where the product couldn't be added to the cart
        //     echo 'Failed to add the product to the cart.';
        // }


        // //insert order mata
        // $new_post = array(
        //     'post_title'    => get_the_title($car_id),
        //     'post_status'   => 'publish',
        //     'post_author'   => $user_id,
        //     'post_type'     => 'car-order',
        // );


        // $post_id = wp_insert_post($new_post);

        // //insert order mata
        // update_post_meta($post_id, 'recovery',  $recovery);
        // update_post_meta($post_id, 'optional',  $optional);
        // update_post_meta($post_id, 'car',  $car_id);
        // update_post_meta($post_id, 'tent',  $tent_id);
        // update_post_meta($post_id, 'location',  $location_id);
        // update_post_meta($post_id, 'pick_up_date',  $pick_up_date);
        // update_post_meta($post_id, 'pick_up_time',  $pick_up_time);
        // update_post_meta($post_id, 'return_date',  $return_date);
        // update_post_meta($post_id, 'return_time',  $return_time);

        // update_post_meta($post_id, 'tax',  $tax);
        // update_post_meta($post_id, 'total_days',  $total_days);
        // update_post_meta($post_id, 'price',  $price);
        // update_post_meta($post_id, 'subtotal',  $subtotal);
        // update_post_meta($post_id, 'grand_total',  $grand_total);
        // update_post_meta($post_id, 'above_22',  $above_22);


        // insert license
        if (isset($_FILES['license']) && !empty($_FILES['license']['name'])) {
            $image = $_FILES['license'];
            $upload_dir = wp_upload_dir();
            $image_name = uniqid() . '_' . $image['name'];
            $image_path = $upload_dir['path'] . '/' . $image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $image_url = $upload_dir['url'] . '/' . $image_name;
            update_user_meta($user_id, 'license',  $image_url);
        }

        //insert pasport
        if (isset($_FILES['passport']) && !empty($_FILES['passport']['name'])) {
            $image = $_FILES['passport'];
            $upload_dir = wp_upload_dir();
            $image_name = uniqid() . '_' . $image['name'];
            $image_path = $upload_dir['path'] . '/' . $image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $image_url = $upload_dir['url'] . '/' . $image_name;
            update_user_meta($user_id, 'passport',  $image_url);
        }

        // $post_url = get_permalink($post_id);
        // wp_redirect($post_url);
    }
}
