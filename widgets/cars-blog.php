<?php
class Elementor_hello_child_cars_blog extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-blog';
    }

    public function get_title()
    {
        return esc_html__('cars-blog', 'elementor-addon');
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
        return ['cars-blog'];
    }

    protected function register_controls()
    {

        // Content Tab Start

        $this->start_controls_section(
            'section_title',
            [
                'label' => esc_html__('Per page blog', 'elementor-addon'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'per_page',
            [
                'label' => esc_html__('Per page blog', 'elementor-addon'),
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
            'post_type' => 'post',
            'posts_per_page' => $settings['per_page'],
        );
        $query = new WP_Query($args);


        // echo "<pre>";
        // print_r($query->posts);
        // echo "</pre>";
?>
        <?php if ($query->have_posts()) : ?>
            <div class="conteiner">
                <div class="row">
                    <?php while ($query->have_posts()) : $query->the_post(); ?>
                        <div class="col-lg-4">
                            <a href="<?php echo get_post_permalink(); ?>">
                                <img class="car-image" src="<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large') ?>" alt="<?php echo get_the_title(get_the_ID()); ?>">
                            </a>
                            <div class="post-date">
                                <p><?php echo get_the_date('F j, Y', get_the_ID()); ?></p>
                            </div>
                            <div class="price-box">
                                <a href="<?php echo get_post_permalink(); ?>">
                                    <p><?php
                                        $title = get_the_title(get_the_ID());

                                        $limited_title = substr($title, 0, 60);

                                        echo $limited_title . '...'; ?>
                                    </p>
                                </a>
                                <p>
                                    <?php echo get_post_meta(get_the_ID(), 'price', true); ?>
                                </p>
                            </div>
                            <div class="description mt-2">
                                <p><?php
                                    $excerpt = get_the_excerpt();

                                    $limited_excerpt = substr($excerpt, 0, 200);

                                    echo $limited_excerpt . '...'; ?></p>
                            </div>
                            <div class="action-button">
                                <div>
                                    <p class="add-to-cart" data-id="<?php echo get_the_ID(); ?>">
                                        <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/share-icon.png" alt="">
                                        Share
                                    </p>
                                </div>
                                <div class="popup-content" id="share-<?php echo get_the_ID(); ?>">
                                    <div class="share-popup">
                                        <div class="share-item">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/instagram-share-icon.png" alt="">
                                            <p>Instagram</p>
                                        </div>
                                        <div class="share-item">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/whatsapp-share-icon.png" alt="">
                                            <p>Whatsapp</p>
                                        </div>
                                        <div class="share-item">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/fb-share-icon.png" alt="">
                                            <p>Facebook</p>
                                        </div>
                                        <div class="share-item">
                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/mail-share-icon.png" alt="" style="width: auto;height: 20px;margin: 0px -9px;">
                                            <p>Mail</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <div class="popup-bg"></div>
        <?php endif; ?>
        <?php wp_reset_postdata(); ?>

        <script>
            jQuery(document).ready(function($) {

                $('.add-to-cart').click(function() {
                    var id = $(this).data('id');
                    var selector = '#share-' + id;
                    $('.popup-bg').show();
                    $(selector).show();

                });

                $('.popup-bg').click(function() {
                    $('.popup-content').hide();
                    $(this).hide();
                });

            });
        </script>

        <style>
            .popup-content {
                display: none;
            }

            .share-item {
                cursor: pointer;
            }

            .popup-bg {
                --bs-backdrop-zindex: 1050;
                --bs-backdrop-opacity: 0.5;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 100;
                width: 100vw;
                height: 100vh;
                background-color: #0000006e;
                display: none;
            }

            .share-popup {
                position: absolute;
                z-index: 110;
                background: #fff;
                width: 370px;
                display: flex;
                height: 160px;
                align-items: center;
                justify-content: space-around;
                border-radius: 20px;
                top: 33px;
                left: 90px;
            }

            .share-item img {
                display: inline-block;
                position: relative !important;
                height: 30px;
                width: auto !important;
                filter: brightness(0);
            }

            .share-item p {
                font-size: 13px;
                margin: 8px 0px;
            }

            .price-box a {
                color: #000;
            }


            .description {
                width: 90%;
            }


            .price-box {
                display: flex;
                gap: 20px;
            }

            .price-box p {
                margin: 0;
                text-transform: uppercase;
                font-size: 18px;
            }

            .action-button .favourite {
                width: 180px;
                padding: 10px 10px;
                color: #575757;
                border: 2px solid #c6c6c6;
                border-radius: 10px;
                position: relative;
                display: inline-block;
                cursor: pointer;
            }

            .action-button img {
                width: 20px;
                position: absolute;
                top: 8px;
                left: 10px;
            }


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
                height: 300px !important;
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

            .action-button .add-to-cart {
                background-color: #f4f4f4;
                text-align: right;
                color: #535353;
                border-radius: 10px;
                font-size: 17px;
                position: relative;
                width: 96px;
                display: inline-block;
                padding: 6px 15px;
                cursor: pointer;
                margin: 0;
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
                margin: 30px 0px;
                align-items: end;
                width: 90%;
                position: relative;
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
