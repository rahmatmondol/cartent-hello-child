<?php

add_action('wp_ajax_get_cars_checkout_page', 'car_checkout_page');
add_action('wp_ajax_nopriv_get_cars_checkout_page', 'car_checkout_page');

function car_checkout_page()
{

    //get all information
    $location_id            = isset($_GET['location_id']) ? $_GET['location_id'] : '';
    $tent_id                = isset($_GET['tent_id']) ? $_GET['tent_id'] : '';
    $car_id                 = isset($_GET['car_id']) ? $_GET['car_id'] : 'no';
    $add_ons_recovery_ids   = isset($_GET['add_ons_recovery']) ? $_GET['add_ons_recovery'] : '';
    $add_ons_optional_ids   = isset($_GET['add_ons_optional']) ? $_GET['add_ons_optional'] : '';
    $pick_up_date           = isset($_GET['pick_up_date']) ? $_GET['pick_up_date'] : '';
    $pick_up_time           = isset($_GET['pick_up_time']) ? $_GET['pick_up_time'] : '';
    $return_date            = isset($_GET['return_date']) ? $_GET['return_date'] : '';
    $return_time            = isset($_GET['return_time']) ? $_GET['return_time'] : '';
    $total_days             = isset($_GET['total_days']) ? $_GET['total_days'] : '';

    //car fetures
    $car_type_id    = get_post_meta($car_id, '_vehicle_type', true);
    $seat           = get_post_meta($car_id, '_seat', true);
    $transmission   = get_term(get_post_meta($car_id, '_transmission', true));
    $off_road       = get_term(get_post_meta($car_id, '_performance', true));
    $car_type       = get_term($car_type_id);
    $tent_type_id   = get_post_meta($car_id, '_tent', true);


    $tent_installation  = get_post_meta($tent_id, '_installation_cost_omr', true);
    $ten_days           = get_post_meta($tent_id, '_10days_omr', true);
    $eleven_days        = get_post_meta($tent_id, '_11days_omr', true);
    $twenty_days        = get_post_meta($tent_id, '_20days_omr', true);

    if ($total_days > 20) {
        $tent_price = $twenty_days;
    } elseif ($total_days > 11) {
        $tent_price = $eleven_days;
    } else {
        $tent_price = $ten_days;
    }


    $insurance = get_post_meta($car_id, '_insurance_per_day_omr', true);

    //add ons recovery 
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'type' => 'recovery_equipment',
        'post_status' => 'publish',
        'include' => $add_ons_recovery_ids
    );

    $query = new WC_Product_Query($args);
    $recoverys = $query->get_products();

    if ($add_ons_recovery_ids) {
        $recoverys_price = 0;
        foreach ($recoverys as $item) {
            $recoverys_price += $item->price;
        }
    }

    //add ons optional 
    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'type' => 'optional_equipment',
        'post_status' => 'publish',
        'include' => $add_ons_optional_ids
    );

    $query = new WC_Product_Query($args);
    $optionals = $query->get_products();

    $optionals_inatalation_cost = 0;
    $optionals_price = 0;

    if ($add_ons_optional_ids) {
        foreach ($optionals as $item) {
            $inatalation = get_post_meta($item->id, 'installation_cost_omr', true);
            $optionals_price += $item->price;
            $optionals_inatalation_cost += $inatalation == 'na' || $inatalation == '' ? 0 : $inatalation;
        }
    }

    //car price
    $price              = get_post_meta($car_id, '_per_day_omr', true);
    $rental_price       =  $price *  $total_days;
    $total_insurance    =  $insurance * $total_days;
    $subtotal           =  $rental_price + $total_insurance;
    $subtotal           =  $subtotal + $tent_installation;
    $subtotal           =  $subtotal + $tent_price * $total_days;
    $subtotal           =  $subtotal + $recoverys_price * $total_days;
    $subtotal           =  $subtotal + $optionals_inatalation_cost;
    $subtotal           =  $subtotal + $optionals_price * $total_days;
    $tax                = round(reset(WC_Tax::get_rates())['rate']);
    $total_tax          = $subtotal / 100 * $tax;
    $grand_total        = $subtotal + $total_tax;

    $user_id            = get_current_user_id();
    $user_mail          = get_userdata($user_id);


    // echo '<pre>';
    // print_r($optionals);
    // echo '</pre>';

?>
    <div class="conteiner">
        <form id="order_add_to_cart" action="<?php echo admin_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="order_submit_handaller">
            <input type="hidden" name="car_id" value="<?php echo $car_id; ?>">
            <input type="hidden" name="tent_id" value="<?php echo $tent_id; ?>">
            <input type="hidden" name="location_id" value="<?php echo $location_id; ?>">
            <input type="hidden" name="pick_up_date" value="<?php echo $pick_up_date; ?>">
            <input type="hidden" name="pick_up_time" value="<?php echo $pick_up_time; ?>">
            <input type="hidden" name="return_date" value="<?php echo $return_date; ?>">
            <input type="hidden" name="return_time" value="<?php echo $return_time; ?>">
            <input type="hidden" name="tax" value="<?php echo $total_tax; ?>">
            <input type="hidden" name="price" value="<?php echo $price; ?>">
            <input type="hidden" name="subtotal" value="<?php echo $subtotal; ?>">
            <input type="hidden" name="grand_total" value="<?php echo $grand_total; ?>">
            <input type="hidden" name="total_days" value="<?php echo $total_days; ?>">

            <?php if ($add_ons_recovery_ids !== '') : ?>
                <?php foreach ($add_ons_recovery_ids as $id) : ?>
                    <input type="hidden" name="recovery[]" value=<?php echo $id; ?>>
                <?php endforeach; ?>
            <?php endif; ?>

            <?php if ($add_ons_optional_ids !== '') : ?>
                <?php foreach ($add_ons_optional_ids as $id) : ?>
                    <input type="hidden" name="optional[]" value=<?php echo $id; ?>>
                <?php endforeach; ?>
            <?php endif; ?>

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
                        <p><?php echo get_the_title($location_id); ?></p>
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
                        <?php if ($recoverys && $add_ons_recovery_ids !== '') : ?>
                            <p style="color: #333;">Off-Road Recovery</p>
                            <?php foreach ($recoverys as $recovery) : ?>
                                <p><?php echo $recovery->name; ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if ($recoverys && $add_ons_optional_ids !== '') : ?>
                            <p style="color: #333;">Optional equepment</p>
                            <?php foreach ($optionals as $optional) : ?>
                                <p><?php echo $optional->name; ?></p>
                            <?php endforeach; ?>
                        <?php endif; ?>

                    </div>
                    <div class="car-detals">
                        <div class="heading">
                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location icon.png" alt="">
                            <h3>Return Location</h3>
                        </div>
                        <p><?php echo get_the_title($location_id); ?></p>
                    </div>
                </div>
            </div>
            <hr class="line">
            <div class="row">
                <div class="col-lg-5 p-4" style="position: relative;">
                    <h2>Features</h2>
                    <ul class="chose-car-feature">
                        <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE.png" alt=""> Vehicle Type: <?php echo isset($car_type->name) ? $car_type->name : ''; ?></li>
                        <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/people-icon.png" alt=""> <?php echo isset($seat) ? $seat : ''; ?></li>
                        <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/transmission-icon.png" alt=""> Transmission: <?php echo isset($transmission->name) ? $transmission->name : ''; ?></li>
                        <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/off-road-performance-icon.png" alt=""> Off Road Performance: <?php echo isset($off_road->name) ? $off_road->name : ''; ?></li>
                        <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT.png" alt="">Roof Tent :
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
                                <p>Insurance <span>( <?php echo $total_days . ' Day(s) x ' . $insurance; ?> )</span></p>
                                <p><?php echo $total_insurance; ?> OMR</p>
                            </div>
                            <div class="details">
                                <p>Tent <span>( <?php echo $total_days . ' Day(s) x ' . $tent_price . ' + Installation Cost ' . $tent_installation; ?> )</span></p>
                                <p><?php echo $tent_price * $total_days + $tent_installation; ?> OMR</p>
                            </div>
                            <?php if ($add_ons_recovery_ids) : ?>
                                <?php foreach ($recoverys as $item) : ?>
                                    <div class="details">
                                        <p><?php echo $item->name ?> <span>( <?php echo $total_days . ' Day(s) x ' . $item->price; ?> )</span></p>
                                        <p><?php echo $item->price * $total_days; ?> OMR</p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                            <?php if ($add_ons_optional_ids) : ?>
                                <?php foreach ($optionals as $item) : ?>
                                    <?php
                                    $inatalation = get_post_meta($item->id, 'installation_cost_omr', true);
                                    $inatalation = $inatalation == 'na' || $inatalation == '' ? 0 : $inatalation;
                                    $inatalation_cost = $inatalation == 0 ? '' : ' + Installation Cost ' . $inatalation;
                                    ?>
                                    <div class="details">
                                        <p><?php echo $item->name ?> <span>( <?php echo $total_days . ' Day(s) x ' . $item->price . $inatalation_cost; ?> )</span></p>
                                        <p><?php echo $total_days * $item->price + $inatalation; ?> OMR</p>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="sumary">
                        <div class="boking-details">
                            <div class="details">
                                <p>Sub Total</p>
                                <p><?php echo $subtotal; ?> OMR</p>
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
                </div>
            </div>
            <hr class="line">
            <div class="row">
                <h2>Driver Details</h2>
                <div class="col-lg-5">
                    <div class="mb-3 form-input">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo get_user_meta($user_id, 'first_name', true); ?>" placeholder="Enter First Name" required>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mb-3 form-input">
                        <label for="Last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="Last-name" name="last-name" value="<?php echo get_user_meta($user_id, 'last_name', true); ?>" placeholder="Enter First Name" required>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mb-3 form-input">
                        <label for="contact-number" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact-number" name="contact-number" value="<?php echo get_user_meta($user_id, 'contact_number', true); ?>" placeholder="Enter Contact Number" required>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="mb-3 form-input">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($user_mail->data) ? $user_mail->data->user_email : ''; ?>" placeholder="Enter Email Addresse" required>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="age-note">
                        <p>Age Above 22 ?</p>
                        <div class="sumary toggle">
                            <div class="boking-details">
                                <div class="details">
                                    <p>I here by confirm that the driver age is
                                        above 22 years</p>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" role="switch" value="1" id="above-22" name="above-22" <?php echo get_user_meta($user_id, 'above_22', true) ? 'checked' : ''; ?>>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="line">
            <div class="row">
                <h2>Upload Verification Documents</h2>
                <div class="col-lg-5">
                    <p class="label">Driver's License</p>
                    <div class="mb-3 form-input-upload">
                        <label for="license" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="license" name="license">
                    </div>
                </div>
                <div class="col-lg-5">
                    <p class="label">Driver's Passport</p>
                    <div class="mb-3 form-input-upload">
                        <label for="passport" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="passport" name="passport">
                    </div>
                </div>
            </div>
            <hr class="line">
            <div class="row">
                <div class="col">
                    <h2>Rental Policies</h2>
                    <div class="policy">
                        <p>All renters must be able to provide a valid driver’s license, passport with visa page and authorized credit card under the main Driver Name.
                            All drivers must carry a locally accepted driving license. <br />

                            UAE RESIDENTS: A valid UAE driving license is a must. Please note that driving without a Valid UAE driving license when on residence or
                            employment visa is a violation of the LAW. <br />

                            NON-RESIDENTS: Visitors are encouraged to have an International Driving License/Permit prior from arrival to the UAE </p>

                        <a href="<?php echo site_url(); ?>/privacy-policy" class="readmore">Read More</a>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="policy-read" required>
                            <label class="form-check-label" for="policy-read">
                                I Have read and agree to the rental policies
                            </label>
                        </div>
                    </div>
                    <div class="submit-button">
                        <button type="submit" name="submit" id="submit" class="submit">Book and Pay Online</button>
                    </div>
                </div>
            </div>
        </form>
    </div>


<?php
    exit;
}
