<?php
class Elementor_hello_child_cars_choose extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-choose';
    }

    public function get_title()
    {
        return esc_html__('cars-choose', 'elementor-addon');
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
        return ['cars-choose'];
    }

    protected function render()
    {

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'type' => 'car',
            'post_status' => 'publish',
        );

        $query = new WC_Product_Query($args);
        $products = $query->get_products();

        $i = 0;
?>


        <?php if ($products) : ?>
            <div class="conteiner">
                <?php foreach ($products as $product) : ?>
                    <?php
                    $car_type_id    = get_post_meta($product->get_id(), '_vehicle_type', true);
                    $seat           = get_post_meta($product->get_id(), '_seat', true);
                    $per_day        = get_post_meta($product->get_id(), '_per_day_omr', true);
                    $per_week       = get_post_meta($product->get_id(), '_per_week_omr', true);
                    $insurance      = get_post_meta($product->get_id(), '_insurance_per_day_omr', true);
                    $per_day_km     = get_post_meta($product->get_id(), '_free_per_day', true);
                    $per_week_km    = get_post_meta($product->get_id(), '_free_per_week', true);
                    $additional_kms = get_post_meta($product->get_id(), '_additional_kms', true);
                    $transmission   = get_term(get_post_meta($product->get_id(), '_transmission', true));
                    $off_road       = get_term(get_post_meta($product->get_id(), '_performance', true));
                    $car_type       = get_term($car_type_id);
                    $tent_id        = get_post_meta($product->get_id(), '_tent', true);
                    ?>
                    <?php if ($i % 2 === 0) : ?>
                        <div class="row cars">
                            <div class="col-lg-5">
                                <a href="<?php echo get_permalink($product->get_id()); ?>">
                                    <img class="car-image" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'large') ?>" alt="<?php echo get_the_title($product->get_id()); ?>">
                                </a>
                            </div>
                            <div class="col-lg-7">
                                <a href="<?php echo get_permalink($product->get_id()); ?>">
                                    <h1 class="title">
                                        <?php echo get_the_title($product->get_id()); ?>
                                    </h1>
                                </a>
                                <div class="row">
                                    <div class="col-lg-6 details">
                                        <div class="details-price">
                                            <p>
                                                <?php echo  $per_day . ' OMR Per Day ' ?><br>
                                                <?php echo  $per_week . ' OMR Per Week ' ?><br>
                                                <?php echo  $insurance . ' OMR Insurance Per Day' ?><br>
                                            </p>
                                        </div>
                                        <hr>
                                        <div class="details-fre">
                                            <p>
                                                <?php echo  'FREE km ' . $per_day_km . ' Per Day ' ?><br>
                                                <?php echo  'Km ' . $per_week_km . ' Per Week ' ?><br>
                                                <?php echo 'Additional Kms @ ' . $additional_kms . ' OMR' ?><br>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ">
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
                                                    echo $tent->name;
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="action-button">
                                    <div>
                                        <a href="<?php echo get_permalink($product->get_id()); ?>" class="book-now">Book Now</a>
                                    </div>
                                    <div class="">
                                        <p class="add-to-wish-list" id="favourite-<?php echo $product->get_id(); ?>" data-id="<?php echo $product->get_id(); ?>">Add to Favourites <i aria-hidden="true" class="far fa-heart"></i></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="row cars">
                            <div class="col-lg-7">
                                <a href="<?php echo get_permalink(); ?>">
                                    <h1 class="title">
                                        <?php echo get_the_title($product->get_id()); ?>
                                    </h1>
                                </a>
                                <div class="row">
                                    <div class="col-lg-6  details">
                                        <div class="details-price">
                                            <p>
                                                <?php echo  $per_day . ' OMR Per Day ' ?><br>
                                                <?php echo  $per_week . ' OMR Per Week ' ?><br>
                                                <?php echo  $insurance . ' OMR Insurance Per Day' ?><br>
                                            </p>
                                        </div>
                                        <hr>
                                        <div class="details-fre">
                                            <p>
                                                <?php echo  'FREE km ' . $per_day_km . ' Per Day ' ?><br>
                                                <?php echo  'Km ' . $per_week_km . ' Per Week ' ?><br>
                                                <?php echo 'Additional Kms @ ' . $additional_kms . ' OMR' ?><br>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 ">
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
                                                    echo $tent->name;
                                                    ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="action-button revers">
                                    <div>
                                        <a href="<?php echo get_permalink($product->get_id()); ?>" class="book-now">Book Now</a>
                                    </div>
                                    <div class="">
                                        <p class="add-to-wish-list" id="favourite-<?php echo $product->get_id(); ?>" data-id="<?php echo $product->get_id(); ?>">Add to Favourites <i aria-hidden="true" class="far fa-heart"></i>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <a href="<?php echo get_permalink($product->get_id()); ?>">
                                    <img class="car-image" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'large') ?>" alt="<?php echo get_the_title($product->get_id()); ?>">
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php $i++;
                endforeach; ?>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>


        <script>
            jQuery(document).ready(function($) {

                var wishlist = JSON.parse(localStorage.getItem('wish-list')) || [];
                if (wishlist.length > 0) {
                    wishlist.filter(function(item) {
                        var selector = '#favourite-' + item;
                        $(selector).text('Added In Wishlist');
                    });
                }

                $('.add-to-wish-list').click(function() {
                    var old_ids = JSON.parse(localStorage.getItem('wish-list')) || [];
                    var new_ids = $(this).data('id');
                    var id = old_ids.filter(function(id) {
                        if (id == new_ids) {
                            return id;
                        }
                    });

                    if (id.length == 0) {
                        old_ids.push(new_ids);
                        localStorage.setItem('wish-list', JSON.stringify(old_ids));
                        $(this).text('added wish list');
                        $('#car-cart').text(old_ids.length);
                    }
                });
            });
        </script>

        <style>
            .add-to-wish-list.already-added i {
                color: #078bff;
            }

            .cars {
                margin-bottom: 80px;
            }

            .action-button.revers {
                display: flex;
                flex-flow: column;
                align-items: baseline;
                gap: 20px;
                margin: 0;
            }

            .details {
                display: flex;
                flex-flow: column;
                justify-content: center;
                gap: 18px;
            }

            .title {
                font-size: 28px;
                color: #333;
            }

            .action-button {
                display: flex;
                flex-flow: column;
                align-items: end;
                gap: 20px;
                margin: 30px 0px;
            }

            .details-price {
                font-size: 18px;
            }

            .action-button .book-now {
                background-color: #000;
                padding: 10px 50px;
                text-align: center;
                color: #fff;
                border-radius: 10px;
                font-size: 18px;
            }

            .action-button .add-to-wish-list {
                text-align: center;
                border: 1px solid #848484;
                border-radius: 10px;
                color: #464646;
                padding: 10px 0px;
                width: 180px;
                cursor: pointer;
            }

            .add-to-wish-list:hover {
                background: #fff;
            }

            .car-image {
                box-shadow: -2px 5px 7px 0px rgba(0, 0, 0, 0.16) !important;
                border-radius: 30px !important;
                width: 95%;
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
        </style>


<?php
    }
}
