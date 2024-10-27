<?php

/**
 * My Account Dashboard
 *
 * Shows the first intro screen on the account dashboard.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/dashboard.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 4.4.0
 */

if (!defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

$user_id = get_current_user_id();
$user_mail = get_userdata($user_id);
?>
<div class="profile">
	<?php if (get_user_meta($user_id, 'profile', true)) : ?>
		<img class="my-account-avater" src="<?php echo get_user_meta($user_id, 'profile', true); ?>" alt="">
	<?php else : ?>
		<img class="my-account-avater" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my-account-avatar.jpeg" alt="">
	<?php endif; ?>
	<p>Hello <?php echo get_user_meta($user_id, 'first_name', true); ?></p>
	<p><?php echo isset($user_mail->data) ? $user_mail->data->user_email : ''; ?></p>
</div>

<?php
/**
 * My Account dashboard.
 *
 * @since 2.6.0
 */
do_action('woocommerce_account_dashboard');

/**
 * Deprecated woocommerce_before_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_before_my_account');

/**
 * Deprecated woocommerce_after_my_account action.
 *
 * @deprecated 2.6.0
 */
do_action('woocommerce_after_my_account');

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
