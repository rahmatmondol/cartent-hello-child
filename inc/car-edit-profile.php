<?php

add_action('admin_post_car_edit_my_account_handaler', 'car_edit_my_account_handaler');
add_action('admin_post_nopriv_car_edit_my_account_handaler', 'car_edit_my_account_handaler');

function car_edit_my_account_handaler()
{

    if (isset($_POST['action']) && $_POST['action'] == 'car_edit_my_account_handaler') {
        $fist_name      = sanitize_text_field($_POST['first-name']);
        $last_name      = sanitize_text_field($_POST['last-name']);
        $email          = sanitize_email($_POST['email']);
        $contact_number = sanitize_text_field($_POST['contact-number']);
        $gender         = sanitize_text_field($_POST['gender']);
        $password       = sanitize_text_field($_POST['password']);
        $above_22       = isset($_POST['above-22']) ? 1 : 0;

        $user_id = get_current_user_id();

        if (!$user_id) {
            $new_user_data = array(
                'user_login'    => $fist_name,
                'user_pass'     => $password,
                'user_email'    =>  $email,
                'display_name'  =>  $fist_name,
                'first_name'    => $fist_name,
                'last_name'     => $last_name,
            );
            // Create new user
            $user_id = wp_insert_user($new_user_data);
            //asign role to car_user
            $user = new WP_User($user_id);
            $user->set_role('car_user');
            $login_data = array(
                'user_login'    => $email,
                'user_password' => $password,
                'remember'      => true,
            );
            wp_signon($login_data);
        }

        update_user_meta($user_id, 'first_name',  $fist_name);
        update_user_meta($user_id, 'last_name',  $last_name);
        update_user_meta($user_id, 'contact_number',  $contact_number);
        update_user_meta($user_id, 'gender',  $gender);
        update_user_meta($user_id, 'above_22',  $above_22);

        // insert profile picture
        if (isset($_FILES['profile']) && !empty($_FILES['profile']['name'])) {
            $image = $_FILES['profile'];
            $upload_dir = wp_upload_dir();
            $image_name = uniqid() . '_' . $image['name'];
            $image_path = $upload_dir['path'] . '/' . $image_name;
            move_uploaded_file($image['tmp_name'], $image_path);
            $image_url = $upload_dir['url'] . '/' . $image_name;
            update_user_meta($user_id, 'profile',  $image_url);
        }

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

        $site = site_url() . '/edit-my-account/';
        wp_redirect($site);
    }
}
