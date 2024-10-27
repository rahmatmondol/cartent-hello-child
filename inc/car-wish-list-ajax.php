<?php

add_action('wp_ajax_get_cars_wish_list', 'car_wish_list');
add_action('wp_ajax_nopriv_get_cars_wish_list', 'car_wish_list');

function car_wish_list()
{
    $ids = isset($_GET['ids']) ? $_GET['ids'] : 0;

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'type' => 'car',
        'post_status' => 'publish',
        'include' => $ids
    );

    $query = new WC_Product_Query($args);
    $cars = $query->get_products();

?>

    <?php if ($cars && $ids > 0) : ?>

        <?php foreach ($cars as $car) : ?>

            <?php
            $car_type_id    = get_post_meta($car->get_id(), '_vehicle_type', true);
            $seat           = get_post_meta($car->get_id(), '_seat', true);
            $transmission   = get_term(get_post_meta($car->get_id(), '_transmission', true));
            $off_road       = get_term(get_post_meta($car->get_id(), '_performance', true));
            $car_type       = get_term($car_type_id);
            $tent_id        = get_post_meta($car->get_id(), '_tent', true);
            ?>

            <div class="col-lg-4">
                <a href="<?php echo get_permalink($car->get_id()); ?>">
                    <img class="car-image" src="<?php echo get_the_post_thumbnail_url($car->get_id(), 'large') ?>" alt="<?php echo get_the_title($car->get_id()); ?>">
                </a>
                <a href="<?php echo get_permalink($car->get_id()); ?>">
                    <h1 class="title">
                        <?php echo get_the_title($car->get_id()); ?>
                    </h1>
                </a>

                <div class="featurs">
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
                            $tent = get_term($tent_id);
                            if (isset($tent->name)) {
                                echo $tent->name;
                            }
                            ?>
                        </li>
                    </ul>
                </div>
                <div class="action-button">
                    <div>
                        <a href="<?php echo get_permalink($car->get_id()); ?>" class="book-now">Book Now</a>
                    </div>
                    <div class="">
                        <a href="<?php echo site_url(); ?>/choose-your-car/" class="add-to-wish-list">Back to Page</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div class="col">
            <div class="no-data">
                <h3>No Wishlist available</h3>
            </div>
        </div>
    <?php endif; ?>


<?php
    exit;
}
