<?php
class Elementor_hello_child_cars_form extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-form';
    }

    public function get_title()
    {
        return esc_html__('cars-form', 'elementor-addon');
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
        return ['cars-form'];
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

        $args = array(
            'post_type' => 'tent',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'ASC'
        );
        $tents = new WP_Query($args);

        $args = array(
            'post_type' => 'recovery-equipment',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'ASC'
        );
        $recovery_equipments = new WP_Query($args);

        $args = array(
            'post_type' => 'optional-equipment',
            'posts_per_page' => -1,
            'orderby' => 'post_date',
            'order' => 'ASC'
        );
        $optional_equipments = new WP_Query($args);


        // echo '<pre>';
        // print_r($optional_equipments->posts);
        // echo '</pre>';


?>

        <div class="car-form-conteiner conteiner">
            <div class="row">
                <div class="col-lg-4 form-items">
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
                                    <div class="col-lg-6">
                                        <ul class="location-lists">
                                            <?php $i = 1; ?>
                                            <?php foreach ($locations->posts as $location) : ?>
                                                <li class="location-item p-2" data-item="<?php echo $i; ?>" data-value="<?php echo $location->post_title; ?>">
                                                    <?php echo  $location->post_title; ?>
                                                </li>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="col-lg-5">
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
                                                    <?php echo get_the_post_thumbnail($location->ID, 'large'); ?>
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
                </div>
                <div class="col-lg-4 form-items">
                    <div class="mb-3">
                        <div class="lavel-group w-100 pb-2">
                            <div class="row">
                                <div class="col-6">
                                    <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/calender  icon.png" alt="">
                                    <label for="pic-up-location" class="form-label">Pic-up Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <label for="pic-up-time" class="form-label m-0">Pic-up time</label>
                                </div>
                            </div>
                        </div>
                        <div class="input-group">
                            <input type="text" class="form" id="pic-up-date">
                            <input type="text" class="form" id="pic-up-time">
                        </div>
                        <div class="picup-time-popup">
                            <ul class="time-lists">

                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 form-items">
                    <div class="mb-3">
                        <div class="lavel-group w-100 pb-2">
                            <div class="row">
                                <div class="col-6">
                                    <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/location icon.png" alt="">
                                    <label for="return-date" class="form-label">Return Date <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-6">
                                    <label for="return-time" class="form-label m-0">Return time</label>
                                </div>
                            </div>

                        </div>
                        <div class="input-group">
                            <input type="text" class="form" id="return-date">
                            <input type="text" class="form" id="return-time">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 form-items">
                    <div class="mb-3">
                        <div class="lavel-group w-100 pb-2">
                            <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE-600x460.png" alt="">
                            <label for="roof-toop-tent" class="form-label">Select Roof Top Tent</label>
                        </div>
                        <input type="text" class="form-control" id="roof-toop-tent" placeholder="Select Tent Type">
                    </div>

                    <div class="roof-toop-select-popup" style="display: none;">
                        <div class="roof-toop_popup_close">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                        </div>
                        <div class="conteiner">
                            <div class="row">
                                <?php if ($tents->have_posts()) : ?>
                                    <div class="row">
                                        <div class="col-9">
                                            <table class="tent-list-table">
                                                <thead>
                                                    <tr>
                                                        <td>Type</td>
                                                        <td>Intallation Cost</td>
                                                        <td>First 10 Days</td>
                                                        <td>11+ Days</td>
                                                        <td>20+ Days</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($tents->posts as $tent) : ?>
                                                        <tr class="tent-item" data-id="<?php echo $tent->ID; ?>" data-title="<?php echo $tent->post_title; ?>">
                                                            <td><?php echo $tent->post_title; ?></td>
                                                            <td>
                                                                <?php
                                                                echo get_post_meta($tent->ID, 'intallation_cost_omr', true) . ' OMR / '
                                                                    . get_post_meta($tent->ID, 'intallation_cost_aud', true) . ' AUD';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo get_post_meta($tent->ID, 'first_10_days_omr', true) . ' OMR / '
                                                                    . get_post_meta($tent->ID, 'first_10_days_aud', true) . ' AUD';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo get_post_meta($tent->ID, '11+_days_omr', true) . ' OMR / '
                                                                    . get_post_meta($tent->ID, '11+_days_aud', true) . ' AUD';
                                                                ?>
                                                            </td>
                                                            <td>
                                                                <?php
                                                                echo get_post_meta($tent->ID, '20+_days_omr', true) . ' OMR / '
                                                                    . get_post_meta($tent->ID, '20+_days_aud', true) . ' AUD';
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="col-3 tent-image-wrap">
                                            <?php foreach ($tents->posts as $tent) : ?>
                                                <div class="tent-image-conten" id="tent-image-<?php echo $tent->ID; ?>">
                                                    <img id="tent-img" src="<?php echo get_the_post_thumbnail_url($tent->ID); ?>" alt="">
                                                    <div class="tent-info-box" data-id="<?php echo $tent->ID; ?>">
                                                        <p>About the Tent</p>
                                                        <i class="fa fa-info"></i>
                                                    </div>
                                                </div>
                                                <div class="about-tent-popup">
                                                    <div class="tent-about-content" id="about-content-<?php echo $tent->ID; ?>">
                                                        <h4><?php echo $tent->post_title; ?></h4>
                                                        <p><?php echo $tent->post_excerpt; ?></p>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <h2>No Location is availavle</h2>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 form-items">
                    <div class="mb-3">
                        <div class="lavel-group w-100 pb-2">
                            <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/addon.png" alt="" style="max-width: 30px;">
                            <label for="addon-selectt" class="form-label">Add-Ons</label>
                        </div>
                        <input type="text" class="form-control" id="addon-select" placeholder="Select Add-Ons ( optional )">
                    </div>
                    <!-- addons popup -->
                    <div class="add-ons-list-popup">
                        <ul class="add-list">
                            <li class="add-ons-list-item off-road-recovery">Off-Road Recovery Equipment</li>
                            <li class="border"></li>
                            <li class="add-ons-list-item optional-equipment">Optional equipment</li>
                        </ul>

                        <!-- recovery equipment popup  -->
                        <div class="recovery-equpment-popup">
                            <div class="recovery-equpmentpopup_close">
                                <i class="fa fa-times-circle" aria-hidden="true"></i>
                            </div>
                            <?php if ($recovery_equipments->have_posts()) : ?>
                                <div class="equpment-info-box">
                                    <p>If you are going across the desert or going to Bar al Hickman it is wise to
                                        take Off-Road recovery Equipment. But you can of course easily get stuck
                                        on any beach with soft sand. So having this equipment is an insurance
                                        against a possible long hot dry walk to get help. Our package includes a
                                        <span class="color-red">Tyre Deflator, a compressor, a pair of Sand Boards</span> and <span class="color-red"> a Kinetic towing
                                            rope with shackles</span>. Before leaving:- Check tyre Deflator gauge is working
                                        Check compressor is working Check towing points on the car Check
                                        shackles can be attached to the towing points
                                    </p>
                                </div>
                                <div class="row">
                                    <div class="col-10">
                                        <div class="notice-box">
                                            <p>Please select below @ 5 OMR per item per day:</p>
                                        </div>
                                        <div class="equpment-option-box">
                                            <ul class="equpment-list">
                                                <?php foreach ($recovery_equipments->posts as $equipment) : ?>
                                                    <li class="equpment-list-item" data-id="<?php echo $equipment; ?>" data-price="<?php echo get_post_meta($equipment->ID, 'price_omr', true) ?>"><?php echo $equipment->post_title; ?><i class="fa fa-circle"></i></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="action-button">
                                            <p class="price">0</p>
                                            <button class="add-to-cart">ADD</button>
                                        </div>
                                    </div>
                                </div>



                            <?php else : ?>
                                <p>No Recovery Equepment Available</p>
                            <?php endif; ?>
                        </div>

                        <!-- optionall equepment popup -->
                        <div class="optional-equpment-popup">
                            <div class="conteiner">
                                <?php if ($optional_equipments->have_posts()) : ?>
                                    <div class="row">
                                        <div class="col-12">
                                            <table class="tent-list-table">
                                                <thead>
                                                    <tr>
                                                        <td class="fist-list">Item</td>
                                                        <td>Cost per Day</td>
                                                        <td class="last-list">Installation cost</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($optional_equipments->posts as $optional_equipment) : ?>
                                                        <?php
                                                        $install =  get_post_meta($optional_equipment->ID, 'installation_cost_omr', true);
                                                        $per_day = get_post_meta($optional_equipment->ID, 'cost_per_day_omr', true);
                                                        $total = intval($install) + intval($per_day);
                                                        ?>
                                                        <tr class="optional_equipment_item" data-id="<?php echo $optional_equipment->ID; ?>" data-price="<?php echo $total; ?>">
                                                            <td class="fist-list"><?php echo $optional_equipment->post_title; ?></td>
                                                            <?php if (get_post_meta($optional_equipment->ID, 'ask_for_price', true) == 'No') : ?>
                                                                <td>
                                                                    <?php
                                                                    echo get_post_meta($optional_equipment->ID, 'cost_per_day_omr', true) == '' ? 'N/A' :
                                                                        get_post_meta($optional_equipment->ID, 'cost_per_day_omr', true)  . ' OMR / '
                                                                        . get_post_meta($optional_equipment->ID, 'cost_per_day_aud', true) . ' AUD';
                                                                    ?>
                                                                </td>
                                                                <td class="last-list">
                                                                    <?php
                                                                    echo get_post_meta($optional_equipment->ID, 'installation_cost_omr', true) == '' ? 'N/A' :
                                                                        get_post_meta($optional_equipment->ID, 'installation_cost_omr', true)  . ' OMR / '
                                                                        . get_post_meta($optional_equipment->ID, 'installation_cost_aud', true) . ' AUD';
                                                                    ?>
                                                                </td>
                                                            <?php else : ?>
                                                                <td>
                                                                    Please Ask for Price
                                                                </td>
                                                                <td class="last-list">

                                                                </td>
                                                            <?php endif; ?>
                                                            <td class="optional_equipments_selected"><i class="fa fa-circle"></i></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="optional-equpment-action-button">
                                                <input class="optional-equpment-price" type="text" readonly value="0" />
                                                <button class="add-to-cart">ADD</button>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <h2>No optional equipments is availavle</h2>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="pupup-close-box"></div>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">

        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>

        <script>
            //optional equpment open
            $('.optional-equipment').on('click', function() {
                $('.recovery-equpment-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $('.pupup-close-box').addClass('active');
                $(this).addClass('active');
                $('.optional-equpment-popup').fadeIn();
            });

            // recovery equpment set price
            $('.optional_equipment_item').click(function() {
                var price = $(this).data('price');
                var old_price = parseInt($('.optional-equpment-price').val());
                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('.optional-equpment-price').val(old_price - price);
                } else {
                    $(this).addClass('active');
                    $('.optional-equpment-price').val(price + old_price);
                }
            });

            // recovery equpments item selection
            $('.equpment-list-item').click(function() {
                $('.equpment-list-item').removeClass('active');
                $(this).addClass('active');
                var price = $(this).data('price');
                $('.price').text(price);

                $('#addon-select').val();
            });

            //off road recovery open
            $('.off-road-recovery').on('click', function() {
                $('.optional-equpment-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $(this).addClass('active');
                $('.recovery-equpment-popup').fadeIn();
                $('.pupup-close-box').addClass('active');

            });

            //recovery equpmentpopup close
            $('.recovery-equpmentpopup_close').click(function() {
                $('.recovery-equpment-popup').fadeOut();
                $(this).removeClass('active');
            });

            // 
            $('#addon-select').on('focus', function() {
                $('.add-ons-list-popup').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //all popup close 
            $('.pupup-close-box').click(function() {
                $('.recovery-equpment-popup').fadeOut();
                $('.location-select-popup').fadeOut();
                $('.roof-toop-select-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $('.optional-equipment').removeClass('active');
                $('.optional-equpment-popup').fadeOut();
                $('.add-ons-list-popup').fadeOut();
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

            //roof toop tent open popup
            $('#roof-toop-tent').on('focus', function() {
                $('.roof-toop-select-popup').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //roof toop select popup close
            $('.roof-toop_popup_close').click(function() {
                $(this).removeClass('active');
                $('.roof-toop-select-popup').fadeOut();
            });


            //location picker functionality
            $('.location-item').on('click', function() {
                var map_item_selector = '#map-' + $(this).data('item');
                var maps = $('.location-map-item').hide();
                var value = $(this).data('value');
                $(map_item_selector).show();

                $('.location-item').removeClass('active');
                $(this).addClass('active');
                $('#pic-up-location').val(value);

                var open_time = $(map_item_selector).data('opentime');
                var close_time = $(map_item_selector).data('closetime');
                $('#pic-up-time').val(open_time.slice(1, 5));
                $('#return-time').val(open_time.slice(1, 5));
            });

            //tent select function
            $('.tent-item').on('click', function() {

                var title = $(this).data('title');
                var id = $(this).data('id');
                var image_url = $(this).data('url');

                $('#roof-toop-tent').val(title);
                $('.tent-item').removeClass('active');
                $(this).addClass('active');

                //set tent image
                $('.tent-image-conten').hide();
                $('#tent-image-' + id).show();
            });

            $('.tent-info-box').hover(function() {
                var selector = '#about-content-' + $(this).data('id');
                $(selector).fadeIn();
            });

            $('.tent-info-box').mouseleave(function() {
                var selector = '#about-content-' + $(this).data('id');
                $(selector).fadeOut();
            });

            //date picker function
            $(function() {
                var dateFormat = "mm/dd/yy",
                    from = $("#pic-up-date")
                    .datepicker({
                        defaultDate: "+1w",
                        numberOfMonths: 1
                    })
                    .on("change", function() {
                        to.datepicker("option", "minDate", getDate(this));
                    }),
                    to = $("#return-date").datepicker({
                        defaultDate: "+1w",
                        numberOfMonths: 1
                    })
                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                    });

                function getDate(element) {
                    var date;
                    try {
                        date = $.datepicker.parseDate(dateFormat, element.value);
                    } catch (error) {
                        date = null;
                    }

                    return date;
                }
            });
            //date picker initializes
            $('#pic-up-time').timepicker({
                timeFormat: 'h:mm',
                interval: 30,
                minTime: '60',
                maxTime: '12:00',
                defaultTime: '09:00',
                startTime: '09:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });

            $('#return-time').timepicker({
                timeFormat: 'h:mm',
                interval: 30,
                minTime: '60',
                maxTime: '12:00',
                defaultTime: '09:00',
                startTime: '09:00',
                dynamic: false,
                dropdown: true,
                scrollbar: true
            });
        </script>

        <style>
            .optional-equpment-price {
                background: #fff;
                display: inline-block;
                width: 120px !important;
                padding: 4px 0px !important;
                border-radius: 5px !important;
                text-align: center;
                margin-right: 10px;
            }

            .optional_equipment_item.active {
                color: #f00;
            }

            .optional_equipment_item td {
                background: #eee !important;
            }

            .optional_equipments_selected {
                padding: 9px 0px 0px 0px !important;
            }

            .optional_equipments_selected i {
                font-size: 18px;
            }

            .optional-equpment-popup .tent-list-table {
                margin: 0;
                padding: 10px 10px 0 10px;
            }

            .last-list {
                border-radius: 0px 10px 10px 0px;
            }

            .optional_equipment_item .optional_equipments_selected {
                background: #fff !important;
            }

            .optional-equpment-action-button {
                background: #eee;
                text-align: center;
                padding: 20px;
            }

            .optional-equpment-action-button p {
                border: 1px solid #333;
                display: inline-block;
                padding: 4px 50px;
                border-radius: 5px;
                margin: 0 10px 0px 0px;
            }

            .optional-equpment-action-button .add-to-cart {
                background: #333;
                border: 0;
                border-radius: 5px;
                color: #fff;
                padding: 5px 30px;
            }

            .optional_equipments_selected {
                background: #fff !important;
            }

            .optional-equpment-popup {
                position: absolute;
                border: 1px solid #333;
                border-radius: 20px;
                z-index: 110;
                background: #fff;
                top: 115px;
                width: 600px;
                overflow: hidden;
                display: none;
                left: 55px;
            }

            .equpment-list-item.active i {
                color: #f00;
            }

            .add-ons-list-item.active {
                color: #f70000;
            }

            .equpment-info-box .color-red {
                color: #f00;
            }

            .recovery-equpment-popup {
                border: 1px solid #5e5c5c;
                border-radius: 20px;
                padding: 10px;
                width: 554px;
                position: absolute;
                top: 45px;
                background: #fff;
                display: none;
                z-index: 110;
                left: 90px;
            }

            .recovery-equpmentpopup_close {
                position: absolute;
                right: 10px;
                top: 10px;
                color: #f93535;
                cursor: pointer;
            }

            .equpment-info-box p {
                font-size: 15px;
                line-height: 25px;
            }

            .notice-box p {
                margin: 0;
                color: #fff;
                font-size: 14px;
                padding: 2px 10px;
            }

            .notice-box {
                background: #333;
                border-radius: 5px;
            }

            .equpment-option-box ul {
                margin: 0;
                padding: 2px 10px;
            }

            .equpment-list li {
                list-style: none;
                display: inline-block;
                cursor: pointer;
                font-size: 16px;
                padding: 4px;
            }

            .equpment-info-box {
                padding-right: 40px;
            }

            .equpment-list-item i {
                font-size: 12px;
                margin-left: 5px;
                color: #ddd;
            }

            .action-button .price {
                padding: 5px 14px;
                border: 1px solid #333;
                text-align: center;
                border-radius: 10px;
                margin: 0px 0px 8px 0px;
            }

            .action-button .add-to-cart {
                border: 1px solid #333;
                padding: 5px 0px;
                border-radius: 10px;
                display: block;
                width: 100%;
                background: #333;
                color: #fff;
            }


            .add-list .border {
                list-style: none;
                border: 2px solid #fff !important;
                position: relative;
                width: 111%;
                left: -6%;
            }

            .add-ons-list-popup {
                background: #eee;
                width: 90%;
                padding: 0px;
                border-radius: 20px;
                display: none;
                position: relative;
                z-index: 110;
            }

            .add-list {
                padding: 0;
            }

            .add-ons-list-item {
                list-style: none;
                padding: 20px 30px;
                cursor: pointer;
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

            #tent-img {
                width: 100%;
                height: 190px;
            }

            .tent-about-content {
                position: absolute;
                width: 330px;
                background: #666;
                border-radius: 20px;
                padding: 10px;
                display: none;
            }

            .tent-about-content h4 {
                font-size: 15px;
                color: #00c899;
                margin: 10px 0px;
            }

            .tent-about-content p {
                font-size: 14px;
                color: #fff;
            }

            .tent-image-conten {
                box-shadow: -3px 3px 5px 2px #dddddd91;
                border-radius: 20px;
                background: #fff;
                display: none;
            }

            .tent-info-box p {
                margin: 0px;
            }

            .tent-item.active {
                color: #f40000;
            }

            .fa.fa-info {
                border: 1px solid;
                border-radius: 50%;
                padding: 5px 8px;
                font-size: 10px;
                cursor: pointer;
                height: 20px;
                margin-left: 7px;
            }

            .tent-info-box:hover .fa.fa-info {
                color: #fd0000;
            }

            .tent-info-box {
                display: flex;
                padding: 5px 10px;
                font-size: 14px;
                align-items: baseline;
                float: right;
            }

            .roof-toop_popup_close {
                position: absolute;
                right: 10px;
                top: 10px;
                cursor: pointer;
                color: #fd0000;
            }

            .tent-image-wrap {
                display: flex;
                align-items: center;
            }

            .tent-list-table thead tr td {
                padding: 10px;
                background: #333;
                color: #fff;
            }

            .tent-list-table tbody {
                font-size: 14px;
            }

            .tent-list-table tbody tr td {
                padding: 7px 5px;
                border: 1px solid #fff;
            }

            .tent-list-table {
                border-collapse: separate;
                border-spacing: 6px 6px;
                cursor: pointer;
            }

            .tent-list-table>thead:nth-child(1)>tr:nth-child(1)>td:nth-child(5) {
                border-radius: 0px 10px 10px 0px;
            }

            .tent-list-table>thead:nth-child(1)>tr:nth-child(1)>td:nth-child(1) {
                border-radius: 10px 0px 0px 10px;
            }

            .tent-list-table>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(5) {
                border-radius: 0px 10px 10px 0px;
            }

            .tent-list-table>tbody:nth-child(1)>tr:nth-child(1)>td:nth-child(1) {
                border-radius: 10px 0px 0px 10px;
            }

            .tent-list-table>tbody td:nth-child(5) {
                border-radius: 0px 10px 10px 0px;
            }

            .tent-list-table>tbody td:nth-child(1) {
                border-radius: 10px 0px 0px 10px;
            }

            .tent-item td {
                background: #eaeaea !important;
            }

            #ui-datepicker-div {
                border-radius: 20px;
                padding: 12px;
                background: #fbfbfbab;
            }

            .ui-datepicker-header.ui-widget-header.ui-helper-clearfix.ui-corner-all {
                border-radius: 10px;
                margin-bottom: 10px;
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
                font-size: 22px;
                cursor: pointer;
            }

            .location-lists {
                padding: 0px;
            }

            .location-select-popup,
            .roof-toop-select-popup {
                display: none;
                position: absolute;
                width: 70%;
                border: 1px solid #c1c1c1;
                border-radius: 10px;
                padding: 10px;
                height: 300px;
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
            }

            .location-map-item {
                display: none;
            }

            .location-details.location-map-item.active {
                display: block;
            }
        </style>

<?php
    }
}
