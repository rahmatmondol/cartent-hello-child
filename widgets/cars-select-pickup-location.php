<?php
class Elementor_hello_child_cars_pickup_location extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-form';
    }

    public function get_title()
    {
        return esc_html__('cars-pickup-location', 'elementor-addon');
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
        return ['cars-pickup-location'];
    }

    protected function render()
    {

        $location_id    = get_post_meta(get_the_ID(), 'select_location', true);

        $args = array(
            'post_type' => 'location',
            'posts_per_page' => -1,
            'post__in' => $location_id
        );
        $locations = new WP_Query($args);
?>

        <div class="mb-3">
            <div class="lavel-group w-100 pb-2">
                <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location icon.png" alt="">
                <label for="pic-up-location" class="form-label">Pic-up Location <span class="text-danger">*</span></label>
            </div>
            <input type="text" class="form-control" id="pic-up-location" placeholder="Select Pic Up Location">
        </div>

        <div class="location-select-popup">
            <div class="popup_close">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </div>
            <div class="conteiner">
                <div class="row">
                    <?php if ($locations->have_posts()) : ?>
                        <div class="col-lg-5">
                            <ul class="location-lists">
                                <?php $i = 1; ?>
                                <?php foreach ($locations->posts as $location) : ?>
                                    <li class="location-item p-2" data-id="<?php echo $location->ID; ?>" data-item="<?php echo $i; ?>" data-value="<?php echo $location->post_title; ?>">
                                        <?php echo  $location->post_title; ?>
                                    </li>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="col-lg-6">
                            <?php $i = 1; ?>
                            <?php foreach ($locations->posts as $location) :  ?>
                                <div class="location-details location-map-item <?php echo $i == 1 ? 'active' : ''; ?>" id="map-<?php echo $i; ?>" data-opentime="<?php echo get_post_meta($location->ID, 'open_time', true); ?>" data-closetime="<?php echo get_post_meta($location->ID, 'close_time', true); ?>">
                                    <div class="time_table">
                                        <ul class="time-lists">
                                            <li class="time-item">
                                                <?php
                                                echo get_post_meta($location->ID, 'open_days_start', true)
                                                    . '-' .
                                                    get_post_meta($location->ID, 'open_days_end', true)
                                                    . ' : ' .
                                                    get_post_meta($location->ID, 'open_time', true)
                                                    . ' - ' .
                                                    get_post_meta($location->ID, 'close_time', true);

                                                ?>
                                            </li>
                                            <li class="time-item">
                                                <?php
                                                echo get_post_meta($location->ID, 'close_days_start', true)
                                                    . '-' .
                                                    get_post_meta($location->ID, 'close_days_end', true)
                                                    . ' : Closed';
                                                ?>
                                            </li>
                                        </ul>

                                    </div>
                                    <div class="location-map">
                                        <iframe src="<?php echo get_post_meta($location->ID, 'link', true); ?>" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <h2>No Location is availavle</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                $('.pupup-close-box').click(function() {
                    $('.location-select-popup').fadeOut();
                    $(this).removeClass('active');
                })

                //location popup open
                $('#pic-up-location').on('focus', function() {
                    $('.location-select-popup').fadeIn();
                    $('.pupup-close-box').addClass('active');
                });

                //location popup close
                $('.popup_close').click(function() {
                    $(this).removeClass('active');
                    $('.location-select-popup').fadeOut();
                });

                //location picker functionality
                $('.location-item').on('click', function() {
                    var map_item_selector = '#map-' + $(this).data('item');
                    var id = $(this).data('id');
                    var maps = $('.location-map-item').hide();
                    var value = $(this).data('value');
                    $(map_item_selector).show();

                    $('.location-item').removeClass('active');
                    $(this).addClass('active');
                    $('#pic-up-location').val(value);

                    localStorage.setItem('location_id', id);
                });
            });
        </script>

        <style>
            .location-map iframe {
                height: 180px;
                border-radius: 10px;
            }

            .input-group::before {
                background: #666;
                position: absolute;
                width: 1px;
                height: 45px;
                content: "";
                left: 50%;
                top: 7px;
            }

            .input-group {
                height: 60px;
                border: 1px solid #666;
                display: flex;
                flex-wrap: nowrap;
                border-radius: 20px;
                position: relative;
                gap: 2px;
            }

            .input-group input {
                display: inline-block;
                border-radius: 20px;
                border: 0;
            }

            .form-control {
                height: 60px;
                border-radius: 20px !important;
            }

            .location-item.active {
                color: #fd0000;
            }

            .popup_close {
                position: absolute;
                bottom: 10px;
                right: 15px;
            }

            .popup_close i {
                color: #ff0202;
                cursor: pointer;
            }

            .lavel-group img {
                width: 40px !important;
            }

            .location-item {
                list-style: none;
                font-size: 16px;
                cursor: pointer;
            }

            .location-lists {
                padding: 0px;
            }

            .location-select-popup {
                display: none;
                position: absolute;
                width: 750px;
                border: 1px solid #c1c1c1;
                border-radius: 10px;
                padding: 10px;
                height: 280px;
                background: #ffffffd9;
                z-index: 110;
            }

            .time-lists {
                padding: 10px 0px;
            }

            .time-item {
                list-style: none;
                font-size: 14px;
            }

            .location-map img {
                width: 100%;
                border-radius: 10px;
                height: 190px;
            }

            .location-map-item {
                display: none;
            }

            .location-details.location-map-item.active {
                display: block;
            }

            .pupup-close-box.active {
                --bs-backdrop-zindex: 1050;
                --bs-backdrop-opacity: 0.5;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 100;
                width: 100vw;
                height: 100vh;
                background-color: var(--bs-backdrop-bg);
            }
        </style>

<?php
    }
}
