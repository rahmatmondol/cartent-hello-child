<?php
class Elementor_hello_child_cars_home extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-home';
    }

    public function get_title()
    {
        return esc_html__('cars-home', 'elementor-addon');
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
        return ['cars-home'];
    }

    protected function register_controls()
    {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Per page cars', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Per page cars', 'elementor-addon'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => esc_html__('3', 'elementor-addon'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $settings = $this->get_settings_for_display();

        $args = array(
            'post_type' => 'car',
            'posts_per_page' => $settings['per_page'],
        );
        $query = new WP_Query($args);

        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $settings['per_page'],
            'type' => 'car',
            'post_status' => 'publish',
        );

        $query = new WC_Product_Query($args);
        $products = $query->get_products();


?>
        <?php if ($products) : ?>
            <div class="conteiner">
                <div class="row">
                    <?php foreach ($products as $product) : ?>
                        <?php
                        $car_type_id    = get_post_meta($product->get_id(), '_vehicle_type', true);
                        $seat           = get_post_meta($product->get_id(), '_seat', true);
                        $per_day        = get_post_meta($product->get_id(), '_per_day_omr', true);
                        $per_week       = get_post_meta($product->get_id(), '_per_week_omr', true);
                        $insurance      = get_post_meta($product->get_id(), '_insurance_per_day_omr', true);
                        $transmission   = get_term(get_post_meta($product->get_id(), '_transmission', true));
                        $off_road       = get_term(get_post_meta($product->get_id(), '_performance', true));
                        $car_type       = get_term($car_type_id);
                        $tent_id        = get_post_meta($product->get_id(), '_tent', true);
                        ?>

                        <div class="col-lg-4">
                            <a href="<?php echo get_permalink($product->get_id()); ?>">
                                <img class="car-image" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'large') ?>" alt="<?php echo get_the_title($product->get_id()); ?>">
                            </a>
                            <a href="<?php echo get_permalink($product->get_id()); ?>">
                                <h1 class="title">
                                    <?php echo get_the_title($product->get_id()); ?>
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
                                        echo $tent->name;
                                        ?>
                                    </li>
                                </ul>
                            </div>
                            <hr class="line">
                            <div class="details-price">
                                <p>
                                    <?php echo  $per_day . ' OMR Per Day ' ?><br>
                                    <?php echo  $per_week . ' OMR Per Week ' ?><br>
                                    <?php echo  $insurance . ' OMR Insurance Per Day' ?><br>
                                </p>
                            </div>
                            <hr class="line">
                            <div class="action-button">
                                <div>
                                    <a href="<?php echo get_permalink($product->get_id()); ?>" class="book-now">View More</a>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>
        <style>
            .line {
                width: 200px;
                height: 2px;
                background-color: #000 !important;
            }

            .featurs {
                margin-bottom: 10px;
            }

            .details-price {
                margin-top: 10px;
            }

            .title {
                font-size: 22px;
                color: #333;
            }

            .car-image {
                box-shadow: -2px 5px 7px 0px rgba(0, 0, 0, 0.16) !important;
                border-radius: 30px !important;
                width: 90%;
                margin-bottom: 20px;
            }

            .chose-car-feature {
                padding: 0;
            }

            .chose-car-feature .feature-list {
                list-style: none;
                padding: 5px 0px;
                font-size: 16px;
            }

            .chose-car-feature .feature-list img {
                width: 30px;
                margin-right: 15px;
            }

            .action-button .book-now {
                background-color: #000;
                padding: 10px 40px;
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
                padding: 10px 28px;
                font-size: 18px;
            }

            .action-button .add-to-wish-list:hover {
                background: #fff;
            }

            .action-button {
                display: flex;
                flex-flow: column;
                gap: 28px;
                margin: 30px 0px;
            }

            .page-title {
                margin-bottom: 40px;
                font-size: 25px;
            }

            .brath {
                display: flex;
                justify-content: start;
                align-items: center;
                margin: 40px 0px;
            }

            .brath img {
                width: 55px;
                height: fit-content;
            }

            .brath h2 {
                font-size: 34px;
            }
        </style>

<?php
    }
}
