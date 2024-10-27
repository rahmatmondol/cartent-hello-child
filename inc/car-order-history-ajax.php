<?php

add_action('wp_ajax_get_cars_order_history', 'car_order_history');
add_action('wp_ajax_nopriv_get_cars_order_history', 'car_order_history');

function car_order_history()
{
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $user_id = get_current_user_id();
    if (!$user_id) {
        exit;
    }

    $orders = wc_get_orders(array(
        'customer' => $user_id,
        'posts_per_page' => 2,
        'paged' => $page,
    ));


    // get location
    function get_location_name($id)
    {
        $location_id = get_post_meta($id, 'location', true);
        return get_the_title($location_id);
    }

    // get location
    function get_details($id)
    {
        $title          = get_the_title($id);
        $tent_id        = get_post_meta($id, 'tent', true);
        $grand_total    = get_post_meta($id, 'grand_total', true);
        $tent           = get_the_title($tent_id);
        $see            = '<a href="' . post_permalink($id) . '">See more details</a>';

        return $title . '<br/> Tent '
            . $tent . '<br/> Total <span>'
            . $grand_total . ' OMR</span>' . $see;
    }

    function add_ordinal_suffix_return($number)
    {
        if ($number % 100 >= 11 && $number % 100 <= 13) {
            return $number . 'th';
        } else {
            switch ($number % 10) {
                case 1:
                    return $number . 'st';
                case 2:
                    return $number . 'nd';
                case 3:
                    return $number . 'rd';
                default:
                    return $number . 'th';
            }
        }
    }

    function show_order_date($date)
    {

        $timestamp = strtotime($date);
        $formatted_month = date(' M', $timestamp);
        $formatted_date = date(' Y',  $timestamp);
        $day = date('j', $timestamp);
        $date = add_ordinal_suffix_return($day);

        return $date . $formatted_month . $formatted_date;
    }




?>
    <?php foreach ($orders as $order) :
        $billing = $order->get_address('billing');
        $payment_method = $order->get_payment_method_title();
        $order_total = $order->get_total();

    ?>

        <tr class="tent-item">
            <td><?php echo $order->ID; ?></td>
            <td><?php echo show_order_date($order->post_date); ?></td>
            <td>
                <?php
                $is_car = false;
                foreach ($order->get_items() as $item) {
                    echo $item['name'] . '<br/>';
                    if ($item->get_meta('is_car')) {
                        $is_car = true;
                    }
                }
                echo 'Total ' . wc_price($order_total);
                ?>
                <?php if ($is_car) : ?>
                    <a href="<?php echo site_url() . '/order-history-details?order-id=' . $order->ID; ?>">See more details</a>
                <?php else : ?>
                    <a href="<?php echo esc_url($order->get_view_order_url()); ?>">See more details</a>
                <?php endif; ?>
            </td>
            <td>
                <?php echo $billing['city']; ?>,
                <?php echo $billing['country']; ?>
            </td>
            <td> <?php echo $payment_method; ?></td>
        </tr>
    <?php endforeach; ?>

<?php
    exit;
}
