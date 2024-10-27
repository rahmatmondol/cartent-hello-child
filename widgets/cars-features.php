<?php
class Elementor_hello_child_cars_features extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-features';
    }

    public function get_title()
    {
        return esc_html__('cars-features', 'elementor-addon');
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
        return ['cars-features'];
    }


    protected function render()
    {
        $car_type_id    = get_post_meta(get_the_ID(), '_vehicle_type', true);
        $seat           = get_post_meta(get_the_ID(), '_seat', true);
        $transmission   = get_term(get_post_meta(get_the_ID(), '_transmission', true));
        $off_road       = get_term(get_post_meta(get_the_ID(), '_performance', true));
        $car_type       = get_term($car_type_id);
        $tent_id        = get_post_meta(get_the_ID(), '_tent', true);

?>

        <ul class="chose-car-feature">
            <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE.png" alt=""> Vehicle Type: <?php echo isset($car_type->name) ? $car_type->name : ''; ?></li>
            <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/people-icon.png" alt=""> <?php echo isset($seat) ? $seat : ''; ?></li>
            <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/transmission-icon.png" alt=""> Transmission: <?php echo isset($transmission->name) ? $transmission->name : ''; ?></li>
            <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/off-road-performance-icon.png" alt=""> Off Road Performance: <?php echo isset($off_road->name) ? $off_road->name : ''; ?></li>
            <li class="feature-list"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT.png" alt="">Roof Tent :
                <?php
                $tent = get_term($tent_id);
                if (isset($tent->name)) {
                    echo $tent->name;
                }
                ?></li>
        </ul>

        <style>
            .chose-car-feature {
                padding: 0;
            }

            .chose-car-feature .feature-list img {
                width: 40px;
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
