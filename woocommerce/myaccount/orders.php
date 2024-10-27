<?php

/**
 * Orders
 *
 * Shows orders on the account page.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/myaccount/orders.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_account_orders', $has_orders);
$my_orders_columns = apply_filters(
	'woocommerce_my_account_my_orders_columns',
	array(
		'order-number'  => esc_html__('Order Number', 'customize-my-account-for-woocommerce'),
		'order-date'    => esc_html__('Order Date', 'customize-my-account-for-woocommerce'),
		'order-details'	=> esc_html__('Order Details', 'customize-my-account-for-woocommerce'),
		'order-location' => esc_html__('Order Location', 'customize-my-account-for-woocommerce'),
		'payment-method'   => esc_html__('Payment Method', 'customize-my-account-for-woocommerce'),
	)
);
?>

<style>
	.myaccount-box {
		width: 90%;
		box-shadow: 0px 0px 10px 10px #ddd;
		border-radius: 30px;
		padding: 30px;
		margin: 0 auto;
		margin-top: 0px;
		margin-top: -50px;
	}

	.woocommerce-MyAccount-navigation,
	.MyAccount-navigation {
		display: none;
	}

	.woocommerce-MyAccount-content {
		width: 100%;
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

	.order-details {
		width: 240px;
	}

	.Order-product-name {
		text-transform: uppercase !important;
		font-size: 17px !important;
	}

	.woocommerce-MyAccount-content {
		margin-left: 15px;
	}

	.date-filter {
		float: right;
		display: flex;
		margin: 15px 0px;
	}

	.date-filter-select {
		width: 118px;
		background: transparent;
		background-position-x: 0%;
		background-position-y: 0%;
		background-repeat: repeat;
		background-image: none;
		background-size: auto;
		background-position-x: 0%;
		background-position-y: 0%;
		background-repeat: repeat;
		background-image: none;
		background-size: auto;
		border-radius: 20px;
		height: 45px;
		padding: 0px 0 0 45px;
		appearance: none;
		background-image: url('https://sparkgarage-oman.com/wp-content/uploads/2023/08/calender.png');
		background-size: 20px;
		background-repeat: no-repeat;
		background-position: 15%;

	}

	.date-filter h2 {
		font-size: 18px;
		padding: 10px 20px;
	}

	#filter-form {
		display: flex;
	}
</style>

<h2 class="site-heading">
	order history
</h2>

<?php if ($has_orders) : ?>

	<?php
	$from_date = '';
	$to_date = '';

	if (isset($_GET['from'])) {
		$from_date = $_GET['from'];
	}
	if (isset($_GET['to'])) {
		$to_date = $_GET['to'];
	}

	$customer_order = get_posts(
		apply_filters(
			'woocommerce_my_account_my_orders_query',
			array(
				'numberposts' => 100,
				'meta_key'    => '_customer_user',
				'meta_value'  => get_current_user_id(),
				'post_type'   => wc_get_order_types('view-orders'),
				'post_status' => array_keys(wc_get_order_statuses()),
				'date_query'  => array(
					'after' => $from_date,
					'before' => $to_date,
					'inclusive' => true,
				),
			)
		)
	);

	?>
	<?php
	$order_dates = get_posts(
		apply_filters(
			'woocommerce_my_account_my_orders_query',
			array(
				'numberposts' => 100,
				'meta_key'    => '_customer_user',
				'meta_value'  => get_current_user_id(),
				'post_type'   => wc_get_order_types('view-orders'),
				'post_status' => array_keys(wc_get_order_statuses()),
			)
		)
	);

	?>


	<div class="myaccount-box">
		<div class="date-filter">
			<form method="get" id="filter-form">
				<select name="from" class="date-filter-select" id="date-select-from">
					<?php foreach ($order_dates as $date) : ?>
						<?php $order      = wc_get_order($date); ?>
						<option value="<?php echo $date->post_date ?>"><?php echo esc_attr($order->get_date_created()->date('d-m-y')); ?></option>
					<?php endforeach; ?>
				</select>
				<h2>
					to
				</h2>
				<select name="to" class="date-filter-select" id="date-select-to" onchange="date_to()">
					<?php foreach ($order_dates as $date) : ?>
						<?php $order      = wc_get_order($date); ?>
						<option value="<?php echo $date->post_date ?>"><?php echo esc_attr($order->get_date_created()->date('d-m-y')); ?></option>
					<?php endforeach; ?>
				</select>
			</form>
			<script>
				function date_to() {
					document.getElementById('filter-form').submit();
				}
			</script>
		</div>
		<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
			<thead>
				<tr>
					<?php foreach ($my_orders_columns as $column_id => $column_name) : ?>
						<th class="<?php echo esc_attr($column_id); ?>"><span class="nobr"><?php echo esc_html($column_name); ?></span></th>
					<?php endforeach; ?>
				</tr>
			</thead>

			<tbody>
				<?php
				foreach ($customer_order as $customer_order) {
					$order      = wc_get_order($customer_order); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
					$item_count = $order->get_item_count();
					$billing 	= $order->get_address('billing');
					$payment_method = $order->get_payment_method();
					$product 		= '';
					$order_permalink = $order;
					foreach ($order->get_items() as $item) {
						$product = $item['name'];
					}
				?>

					<tr class="order">
						<td class="order-number">
							<?php echo $order->get_order_number(); ?>
						</td>
						<td class="Order-date">
							<time datetime="<?php echo esc_attr($order->get_date_created()->date('c')); ?>">
								<?php echo esc_html(wc_format_datetime($order->get_date_created())); ?>
							</time>
						</td>
						<td class="Order-product-name">
							<span><?php echo $product; ?></span><br />
							<a href="<?php echo esc_url($order->get_view_order_url()); ?>">See more details</a>
						</td>
						<td class="Order-location">
							<?php echo $billing['city']; ?>,
							<?php echo $billing['country']; ?>
						</td>
						<td class="Order-payment-mathod">
							<?php echo $payment_method; ?>,
						</td>
					</tr>
				<?php
				}
				?>
			</tbody>
		</table>



		<?php do_action('woocommerce_before_account_orders_pagination'); ?>

		<?php if (1 < $customer_orders->max_num_pages) : ?>
			<div class="order-pagination">
				<?php for ($i = 0; $i < $customer_orders->max_num_pages; $i++) : ?>
					<a class="pagination-link <?php if ($current_page == $i + 1) {
													echo 'active';
												} ?>" href="<?php echo esc_url(wc_get_endpoint_url('orders',  $i + 1)); ?>"><?php echo $i + 1; ?></a>
				<?php endfor; ?>
			</div>
		<?php endif; ?>
	</div>



<?php else : ?>
	<style>
		.myaccount-no-order {
			text-align: center;
			width: 600px;
			margin: 0 auto;
			background: #19191A;
			padding: 60px;
			border-radius: 30px;
			color: #fff;
			font-size: 12px;
		}
	</style>
	<div class="myaccount-no-order">
		<h2>
			Currently No Orders Have Been Placed
		</h2>
	</div>

<?php endif; ?>

<?php do_action('woocommerce_after_account_orders', $has_orders); ?>