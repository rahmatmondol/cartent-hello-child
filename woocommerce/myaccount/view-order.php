<?php

/**
 * View Order
 *
 * Shows the details of a particular order on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/view-order.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.0.0
 */

defined('ABSPATH') || exit;

$notes = $order->get_customer_order_notes();
?>
<style>
	.myaccount-box {
		width: 100%;
		box-shadow: 0px 0px 10px 10px #ddd;
		border-radius: 30px;
		padding: 30px;
	}

	.woocommerce-MyAccount-navigation,
	.MyAccount-navigation {
		display: none;
	}

	.woocommerce-MyAccount-content {
		width: 70% !important;
		margin: 0 auto;
		float: none !important;
	}

	.site-heading {
		font-family: "Best In Class";
		font-size: 35px;
		text-transform: uppercase;
		color: #373737;
		font-weight: 500;
		position: relative;
		top: -60px;
		left: -47px;
	}

	.woocommerce-order-details__title {
		display: none;
	}

	.brath {
		display: flex;
		justify-content: start;
		align-items: center;
		margin: 40px 0px;
	}

	.brath img {
		width: 31px;
		height: fit-content;
	}

	.brath h2 {
		font-size: 34px;
	}

	.woocommerce {
		margin-top: -110px;
	}

	.woocommerce-order-details {
		max-width: 100% !important;
		box-shadow: 0 0px 10px 10px #ddddddd1;
		border-radius: 30px;
		padding: 30px;
	}

	.woocommerce-order-details table thead tr th {
		background: #54595F !important;
		color: #fff;
		font-size: 22px !important;
	}

	.woocommerce-customer-details {
		display: none;
	}

	.woocommerce-table.woocommerce-table--order-details.shop_table.order_details tr td {
		border-color: #eee;
	}

	.woocommerce-table.woocommerce-table--order-details.shop_table.order_details tfoot tr th {
		border-color: #fff;
		background: #ececec;
	}
</style>
<div class="brath">
	<img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
	<h2>Order History</h2>
	<span>More details</span>
</div>
<p>
	<?php
	printf(
		/* translators: 1: order number 2: order date 3: order status */
		esc_html__('Order #%1$s was placed on %2$s and is currently %3$s.', 'woocommerce'),
		'<mark class="order-number">' . $order->get_order_number() . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<mark class="order-date">' . wc_format_datetime($order->get_date_created()) . '</mark>', // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		'<mark class="order-status">' . wc_get_order_status_name($order->get_status()) . '</mark>' // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	);
	?>
</p>

<?php if ($notes) : ?>
	<ol class="woocommerce-OrderUpdates commentlist notes">
		<?php foreach ($notes as $note) : ?>
			<li class="woocommerce-OrderUpdate comment note">
				<div class="woocommerce-OrderUpdate-inner comment_container">
					<div class="woocommerce-OrderUpdate-text comment-text">
						<p class="woocommerce-OrderUpdate-meta meta"><?php echo date_i18n(esc_html__('l jS \o\f F Y, h:ia', 'woocommerce'), strtotime($note->comment_date)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
																		?></p>
						<div class="woocommerce-OrderUpdate-description description">
							<?php echo wpautop(wptexturize($note->comment_content)); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped 
							?>
						</div>
						<div class="clear"></div>
					</div>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach; ?>
	</ol>
<?php endif; ?>

<?php do_action('woocommerce_view_order', $order_id); ?>