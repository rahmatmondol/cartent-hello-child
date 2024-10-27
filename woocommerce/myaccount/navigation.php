<?php

/**
 * My Account navigation
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 2.6.0
 */

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation">
	<div class="account-nav">
		<ul>
			<li>
				<a href="<?php echo site_url(); ?>/my-account">
					<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my account icon.png" alt="">
					<p class="active">My Account</p>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url(); ?>/edit-my-account/">
					<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/edit my account icon.png" alt="">
					<p>Edit My Account</p>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url(); ?>/order-history/">
					<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
					<p>Order History</p>
				</a>
			</li>
			<li>
				<a href="<?php echo site_url(); ?>/wish-list/">
					<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wishlist icon.png" alt="">
					<p>Wish List</p>
				</a>
			</li>
			<li>
				<a href="<?php echo wp_logout_url(); ?>">
					<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/log out icon.png" alt="">
					<p>Log Out</p>
				</a>
			</li>
		</ul>
		<hr class="line">
	</div>
</nav>
<style>
	.account-nav .active {
		font-size: 22px;
		font-weight: 600;
	}

	.profile img {
		border-radius: 20px;
		width: 150px;
		margin-bottom: 10px;
	}

	.profile p {
		padding: 0;
		margin: 0;
		color: #575757;
	}

	.account-nav ul img {
		width: 30px;
	}

	.account-nav ul li {
		list-style: none;
	}

	.account-nav ul img {
		display: inline-block;
	}

	.account-nav ul p {
		display: inline-block;
		padding: 3px 3px;
		color: #000;
	}

	.account-nav ul p:hover {
		color: #bdbdbd;
	}

	.line {
		background-color: #000 !important;
		height: 3px;
		rotate: 90deg;
		width: 270px;
		position: absolute;
		right: -100px;
		top: 132px;
	}

	.account-nav {
		position: relative;
	}

	.entry-title {
		display: none !important;
	}
</style>
<?php do_action('woocommerce_after_account_navigation'); ?>