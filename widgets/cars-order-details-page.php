<?php
class Elementor_hello_child_cars_order_details_page extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-order_details_page';
    }

    public function get_title()
    {
        return esc_html__('cars-order_details_page', 'elementor-addon');
    }

    public function get_icon()
    {
        return 'eicon-code';
    }

    public function get_categories()
    {
        return ['basic'];
    }

    public function get_keywords()
    {
        return ['cars-order_details_page'];
    }


    protected function render()
    {
        $order_id = isset($_GET['order-id']) ? $_GET['order-id'] : false;
        //get all information
        if ($order_id) {
            $user_id = get_current_user_id();

            $orders = wc_get_order($order_id);

            //get all information
            $car_id         = '';
            $recovery_id    = [];
            $optional_id    = [];
            $location       = '';
            $pick_up_date   = '';
            $pick_up_time   = '';
            $return_date    = '';
            $return_time    = '';
            $total_days     = '';
            $car_insurance  = '';
            $tent_id        = '';
            $tent_price     = '';

            //get all information
            foreach ($orders->get_items() as $item) {
                if ($item->get_meta('is_car')) {
                    $car_id         = $item['product_id'];
                    $location       = $item->get_meta('location');
                    $pick_up_date   = $item->get_meta('pickup_date');
                    $pick_up_time   = $item->get_meta('pickup_time');
                    $return_date    = $item->get_meta('return_date');
                    $return_time    = $item->get_meta('return_time');
                    $total_days     = $item->get_meta('total_days');
                    $car_insurance  = get_post_meta($car_id, '_insurance_per_day_omr', true);
                }
                if ($item->get_meta('is_recovery')) {
                    $recovery_id[] = $item['product_id'];
                }
                if ($item->get_meta('is_optional')) {
                    $optional_id[] = $item['product_id'];
                }
                if ($item->get_meta('is_tent')) {
                    $tent_id = $item['product_id'];
                }
            }


            $tent_installation   = get_post_meta($tent_id, '_installation_cost_omr', true);
            $ten_days       = get_post_meta($tent_id, '_10days_omr', true);
            $eleven_days    = get_post_meta($tent_id, '_11days_omr', true);
            $twenty_days    = get_post_meta($tent_id, '_20days_omr', true);

            if ($total_days > 20) {
                $tent_price = $twenty_days;
            } elseif ($total_days > 11) {
                $tent_price = $eleven_days;
            } else {
                $tent_price = $ten_days;
            }

            $price                  = get_post_meta($car_id, 'price', true);
            $above_22               = get_post_meta($car_id, 'above_22', true);

            $total_tax      = $orders->get_total_tax();
            $grand_total    = $orders->get_total();

            //car fetures
            $car_type_id    = get_post_meta($car_id, '_vehicle_type', true);
            $seat           = get_post_meta($car_id, '_seat', true);
            $transmission   = get_term(get_post_meta($car_id, '_transmission', true));
            $off_road       = get_term(get_post_meta($car_id, '_performance', true));
            $car_type       = get_term($car_type_id);
            $tent_type_id   = get_post_meta($car_id, '_tent', true);

            //add ons recovery 
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'type' => 'recovery_equipment',
                'post_status' => 'publish',
                'include' => $recovery_id
            );

            $query = new WC_Product_Query($args);
            $recoverys = $query->get_products();

            //add ons optional 
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'type' => 'optional_equipment',
                'post_status' => 'publish',
                'include' => $optional_id
            );

            $query = new WC_Product_Query($args);
            $optionals = $query->get_products();



            //car price
            $price          = get_post_meta($car_id, '_per_day_omr', true);
            $rental_price   =  $price *  $total_days;


?>
            <div class="conteiner">
                <div class="row">
                    <div class="brath">
                        <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
                        <h2>Order History</h2>
                        <span>More details</span>
                    </div>
                </div>
                <form id="order_add_to_cart" action="<?php echo admin_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6">
                            <h1 class="title"><?php echo get_the_title($car_id); ?></h1>
                            <img class="car-image" src="<?php echo get_the_post_thumbnail_url($car_id, 'large') ?>" alt="">
                        </div>
                        <div class="col-lg-6 selected-options">
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location icon.png" alt="">
                                    <h3>Pick-Up Location</h3>
                                </div>
                                <p><?php echo $location; ?></p>
                            </div>
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/calender  icon.png" alt="">
                                    <h3>Pick-Up Date and Time</h3>
                                </div>
                                <p><?php
                                    function add_ordinal_suffix($number)
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
                                    $timestamp = strtotime($pick_up_date);
                                    $formatted_date = date(' M', $timestamp);
                                    $day = date('j', $timestamp);
                                    $date = add_ordinal_suffix($day);

                                    $timestamp = strtotime($pick_up_time);
                                    $formatted_time = date(' h:i', $timestamp);

                                    echo $date . $formatted_date . $formatted_time;
                                    ?></p>
                            </div>
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/calender  icon.png" alt="">
                                    <h3>Return Date and Time</h3>
                                </div>
                                <p><?php
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
                                    $timestamp = strtotime($return_date);
                                    $formatted_date = date(' M', $timestamp);
                                    $day = date('j', $timestamp);
                                    $date = add_ordinal_suffix_return($day);

                                    $timestamp = strtotime($return_time);
                                    $formatted_time = date(' h:i', $timestamp);

                                    echo $date . $formatted_date . $formatted_time;
                                    ?></p>
                            </div>
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE.png" alt="">
                                    <h3>Select Roof Top Tent</h3>
                                </div>
                                <p><?php echo get_the_title($tent_id); ?></p>
                            </div>
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/addon.png" alt="" style="width: 26px;margin-left: 6px;">
                                    <h3>ADD-Ons</h3>
                                </div>
                                <?php if ($recoverys && $recoverys !== '') : ?>
                                    <p style="color: #333;">Off-Road Recovery</p>
                                    <?php foreach ($recoverys as $recovery) : ?>
                                        <p><?php echo $recovery->get_name(); ?></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                                <?php if ($optionals && $optionals !== '') : ?>
                                    <p style="color: #333;">Optional equepment</p>
                                    <?php foreach ($optionals as $optional) : ?>
                                        <p><?php echo $optional->get_name(); ?></p>
                                    <?php endforeach; ?>
                                <?php endif; ?>

                            </div>
                            <div class="car-detals">
                                <div class="heading">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location icon.png" alt="">
                                    <h3>Return Location</h3>
                                </div>
                                <p><?php echo $location; ?></p>
                            </div>
                        </div>
                    </div>
                    <hr class="line">
                    <div class="row">
                        <div class="col-lg-5 p-4" style="position: relative;">
                            <h2>Features</h2>
                            <ul class="chose-car-feature">
                                <li class="feature-list">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE.png" alt="">
                                    Vehicle Type: <?php echo isset($car_type->name) ? $car_type->name : ''; ?>
                                </li>
                                <li class="feature-list">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/people-icon.png" alt="">
                                    <?php echo isset($seat) ? $seat : ''; ?>
                                </li>
                                <li class="feature-list">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/transmission-icon.png" alt="">
                                    Transmission: <?php echo isset($transmission->name) ? $transmission->name : ''; ?>
                                </li>
                                <li class="feature-list">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/off-road-performance-icon.png" alt="">
                                    Off Road Performance: <?php echo isset($off_road->name) ? $off_road->name : ''; ?>
                                </li>
                                <li class="feature-list">
                                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT.png" alt="">
                                    Roof Tent :
                                    <?php
                                    $car_tent = get_term($tent_type_id);
                                    if (isset($car_tent->name)) {
                                        echo $car_tent->name;
                                    } ?>
                                </li>
                            </ul>
                            <span class="line-vertical"></span>
                        </div>

                        <div class="col-lg-6 p-4">
                            <div class="sumary">
                                <div class="days">
                                    <p>Total Days</p>
                                    <p><?php echo $total_days; ?> Days</p>
                                </div>
                                <div class="boking-details">
                                    <p>Boking Details</p>
                                    <div class="details">
                                        <p>Rental Charge <span>( <?php echo $total_days . ' Day(s) x ' . $price; ?> )</span></p>
                                        <p><?php echo $rental_price; ?> OMR</p>
                                    </div>
                                    <div class="details">
                                        <p>Insurance <span>( <?php echo $total_days . ' Day(s) x ' . $car_insurance; ?> )</span></p>
                                        <p><?php echo $car_insurance * $total_days; ?> OMR</p>
                                    </div>
                                    <div class="details">
                                        <p>Tent <span>( <?php echo $total_days . ' Day(s) x ' . $tent_price . ' + Installation Cost ' . $tent_installation; ?> )</span></p>
                                        <p><?php echo $tent_price * $total_days + $tent_installation; ?> OMR</p>
                                    </div>
                                    <?php foreach ($recoverys as $item) : ?>
                                        <div class="details">
                                            <p><?php echo $item->get_name() ?> <span>( <?php echo $total_days . ' Day(s) x ' . $item->get_price(); ?> )</span></p>
                                            <p><?php echo $item->get_price() * $total_days; ?> OMR</p>
                                        </div>
                                    <?php endforeach; ?>
                                    <?php foreach ($optionals as $item) : ?>
                                        <?php
                                        $inatalation = get_post_meta($item->get_id(), 'installation_cost_omr', true);
                                        $inatalation = $inatalation == 'na' || $inatalation == '' ? 0 : $inatalation;
                                        $inatalation_cost = $inatalation == 0 ? '' : ' + Installation Cost ' . $inatalation;
                                        ?>
                                        <div class="details">
                                            <p><?php echo $item->get_name() ?> <span>( <?php echo $total_days . ' Day(s) x ' . $item->get_price() . $inatalation_cost; ?> )</span></p>
                                            <p><?php echo $total_days * $item->get_price() + $inatalation; ?> OMR</p>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                            <div class="sumary">
                                <div class="boking-details">
                                    <div class="details">
                                        <p>Sub Total</p>
                                        <p><?php echo $grand_total - $total_tax; ?> OMR</p>
                                    </div>
                                </div>
                            </div>
                            <div class="sumary">
                                <div class="boking-details">
                                    <div class="details">
                                        <p>Tax Total</p>
                                        <p><?php echo $total_tax; ?> OMR</p>
                                    </div>
                                </div>
                            </div>
                            <div class="sumary grand-totol">
                                <div class="boking-details">
                                    <div class="details">
                                        <p>Grand Total</p>
                                        <p><?php echo $grand_total; ?> OMR</p>
                                    </div>
                                </div>
                            </div>
                            <div class="sumary-note">
                                <div class="boking-details">
                                    <div class="details">
                                        <p><span class="text-danger">*</span>Please Note Upon checkout 150 OMR will be added as a
                                            <span class="text-danger">refundable</span> cover charge ( This charge cover any fines or
                                            damages sustained during the rental period .
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="sumary toggle">
                                <div class="boking-details">
                                    <div class="details">
                                        <p>click toggle to add to bill</p>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="billing-togle">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="submit-button">
                                <a href="<?php echo get_permalink($car_id); ?>" name="submit" id="submit" class="submit">Book Again</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <style>
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

                .boking-details .details {
                    display: flex;
                    align-items: center;
                    gap: 72px;
                    border-radius: 13px;
                }

                #above-22 {
                    padding: 19px;
                    width: 85px;
                    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/toggle.png ?>");
                    background-color: #969695;
                }

                #above-22:checked {
                    background-color: #4ba473;
                    border-color: #4ba473;
                }

                .submit-button {
                    text-align: right;
                    margin-top: 100px;
                }

                .submit-button .submit {
                    border: 0px;
                    background: #575757;
                    color: #fff;
                    padding: 10px 35px;
                    border-radius: 10px;
                }

                .policy {
                    padding: 20px 0px;
                    display: flex;
                    flex-flow: column;
                    gap: 20px;
                }

                .policy p {
                    font-size: 16px;
                    line-height: 20px;
                }

                .policy p br {
                    margin: 10px;
                }

                .policy .readmore {
                    background: #e0dede;
                    padding: 10px 20px;
                    border-radius: 10px;
                    color: #333;
                    align-self: start;
                }

                .policy .form-check {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .policy .form-check input {
                    padding: 12px;
                }

                .form-input-upload .form-label {
                    background: #404040;
                    color: #c1c1c1;
                    padding: 20px 60px;
                    border-radius: 17px;
                    position: absolute;
                    cursor: pointer;
                    font-size: 20px;
                }

                .form-input-upload {
                    position: relative;
                }

                .form-input-upload input {
                    height: 50px;
                    border: 0px solid #fff0;
                    color: #bfbfbf;
                    padding: 16px 14px 0 127px;
                    font-size: 18px;
                }

                .age-note {
                    padding: 20px;
                }

                .form-input {
                    padding: 10px 20px;
                }

                .form-input input {
                    border-radius: 15px;
                    height: 60px;
                    border-color: #ddd;
                }

                .form-input label {
                    font-size: 16px;
                }

                .sumary.toggle {
                    color: #777;
                }

                #billing-togle:checked {
                    background-color: #4ba473;
                    border-color: #4ba473;
                }

                #billing-togle {
                    padding: 19px;
                    width: 85px;
                    background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/toggle.png ?>");
                    background-color: #969695;
                }

                .sumary-note {
                    padding: 10px;
                    margin: 10px 10px;
                }

                .line-vertical {
                    border: 1px solid #ddd;
                    height: 320px;
                    display: block;
                    width: 1px;
                    position: absolute;
                    top: 0;
                    right: 0;
                }

                .details {
                    display: flex;
                    justify-content: space-between;
                }

                .details p {
                    margin: 0;
                }

                .boking-details {
                    margin: 0px 0px;
                    padding-right: 30px;
                }

                .boking-details>p {
                    margin: 0;
                }

                .details p span {
                    font-size: 90%;
                    color: #757575;
                }

                .sumary.grand-totol {
                    background: #333 !important;
                    color: #fff;
                }

                .sumary {
                    background: #eee;
                    padding: 12px 20px;
                    border-radius: 20px;
                    font-size: 18px;
                    color: #000;
                    margin-bottom: 10px;
                }

                .days {
                    display: flex;
                    justify-content: space-between;
                    padding-right: 30px;
                }

                .days>p {
                    margin-bottom: 25px;
                }

                .chose-car-feature {
                    padding: 0;
                }

                .chose-car-feature .feature-list img {
                    width: 30px;
                    margin-right: 15px;
                }

                .chose-car-feature .feature-list {
                    list-style: none;
                    padding: 10px;
                    font-size: 17px;
                }

                .line {
                    margin: 50px 0px !important;
                }

                .car-detals {
                    padding: 5px;
                }

                .selected-options {
                    display: flex;
                    flex-flow: column;
                    justify-content: center;
                    padding-left: 30px;
                }

                .title {
                    font-size: 28px;
                }

                .car-image {
                    object-position: center center;
                    border-radius: 30px !important;
                    box-shadow: -2px 5px 6px 1px rgba(0, 0, 0, 0.33) !important;
                }

                .car-detals p {
                    font-size: 14px;
                    color: #f00000;
                    margin-left: 40px;
                    margin-bottom: 0;
                }

                .car-detals .heading {
                    display: flex;
                    align-items: center;
                }

                .car-detals .heading img {
                    width: 36px;
                    display: inline-block;
                }

                .car-detals .heading h3 {
                    display: inline-block;
                    margin: 0px 5px;
                    font-size: 16px;
                }
            </style>

<?php
        }
    }
}
