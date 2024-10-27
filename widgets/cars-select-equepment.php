<?php
class Elementor_hello_child_cars_select_equepment extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-select-equepment';
    }

    public function get_title()
    {
        return esc_html__('cars-select-equepment', 'elementor-addon');
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
        return ['cars-select-equepment'];
    }

    protected function render()
    {

        $args = array(
            'post_type'         => 'product',
            'posts_per_page' => -1,
            'type' => 'recovery_equipment',
            'post_status' => 'publish',
            'order' => 'ASC'
        );

        $query = new WC_Product_Query($args);
        $recovery_equipments = $query->get_products();


        $args = array(
            'post_type'         => 'product',
            'posts_per_page' => -1,
            'type' => 'optional_equipment',
            'post_status' => 'publish',
            'order' => 'ASC'
        );

        $query = new WC_Product_Query($args);
        $optional_equipments = $query->get_products();

?>

        <div class="addon-select-wraper">
            <div class="lavel-group w-100 pb-2">
                <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/addon.png" alt="" style="max-width: 25px;">
                <label for="addon-select" class="form-label m-0">Add-Ons</label>
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
                <?php if ($recovery_equipments) : ?>
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
                                    <?php foreach ($recovery_equipments as $equipment) : ?>
                                        <li class="equpment-list-item" data-id="<?php echo $equipment->get_id(); ?>" data-price="<?php echo get_post_meta($equipment->get_id(), '_recovery_price_omr', true) ?>">
                                            <?php echo $equipment->get_name(); ?>
                                            <i class="fa fa-circle"></i>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="action-button">
                                <p class="price">0</p>
                                <button class="add-to-cart recovery-add">ADD</button>
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
                    <?php if ($optional_equipments) : ?>
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
                                        <?php foreach ($optional_equipments as $optional_equipment) : ?>
                                            <?php
                                            $install =  get_post_meta($optional_equipment->get_id(), 'installation_cost_omr', true);
                                            $per_day = get_post_meta($optional_equipment->get_id(), 'per_day_omr', true);
                                            $total = intval($install) + intval($per_day);
                                            ?>
                                            <tr class="optional_equipment_item" data-id="<?php echo $optional_equipment->get_id(); ?>" data-price="<?php echo $total; ?>">
                                                <td class="fist-list"><?php echo $optional_equipment->get_name(); ?></td>
                                                <?php if (get_post_meta($optional_equipment->get_id(), 'per_day_omr', true) !== 'na' ||  get_post_meta($optional_equipment->get_id(), 'installation_cost_omr', true) !== 'na')  : ?>
                                                    <td>
                                                        <?php
                                                        echo get_post_meta($optional_equipment->get_id(), 'per_day_omr', true) == 'na' ? 'N/A' :
                                                            get_post_meta($optional_equipment->get_id(), 'per_day_omr', true)  . ' OMR / '
                                                            . get_post_meta($optional_equipment->get_id(), '_per_day_aud', true) . ' AUD';
                                                        ?>
                                                    </td>
                                                    <td class="last-list">
                                                        <?php
                                                        echo get_post_meta($optional_equipment->get_id(), 'installation_cost_omr', true) == 'na' ? 'N/A' :
                                                            get_post_meta($optional_equipment->get_id(), 'installation_cost_omr', true)  . ' OMR / '
                                                            . get_post_meta($optional_equipment->get_id(), 'installation_cost_aud', true) . ' AUD';
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
                                    <button class="add-to-cart optional-add">ADD</button>
                                </div>
                            </div>
                        </div>
                    <?php else : ?>
                        <h2>No optional equipments is availavle</h2>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            // optional menu items opening
            $('#addon-select').on('focus', function() {
                $('.add-ons-list-popup').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //optional equpment open
            $('.optional-equipment').on('click', function() {
                $('.recovery-equpment-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $('.pupup-close-box').addClass('active');
                $(this).addClass('active');
                $('.optional-equpment-popup').fadeIn();
            });

            localStorage.removeItem('optional_equpment_ids');
            localStorage.removeItem('recovery_equpment_ids');


            // optional equpment set price
            $('.optional_equipment_item').click(function() {
                var price = $(this).data('price');
                var id = $(this).data('id');
                var old_price = parseInt($('.optional-equpment-price').val());
                var old_ids = JSON.parse(localStorage.getItem('optional_equpment_ids')) || [];

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('.optional-equpment-price').val(old_price - price);

                    old_ids = old_ids.filter(function(item) {
                        return item !== id;
                    });
                    localStorage.setItem('optional_equpment_ids', JSON.stringify(old_ids));
                } else {
                    old_ids.push(id);
                    localStorage.setItem('optional_equpment_ids', JSON.stringify(old_ids));

                    $(this).addClass('active');
                    $('.optional-equpment-price').val(price + old_price);
                }
            });

            // optional equpment item add
            $('.optional-add').click(function() {
                var all_ids = JSON.parse(localStorage.getItem('optional_equpment_ids')) || [];
                $('#addon-select').val('Optional Equpment, ' + all_ids.length + ' item');
                $('.optional-equpment-popup').fadeOut();
                $(this).removeClass('active');
            });


            //off road recovery open
            $('.off-road-recovery').on('click', function() {
                $('.optional-equpment-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $(this).addClass('active');
                $('.recovery-equpment-popup').fadeIn();
                $('.pupup-close-box').addClass('active');

            });

            // recovery equpments item selection
            $('.equpment-list-item').click(function() {
                var price = $(this).data('price');
                var id = $(this).data('id');
                var old_price = parseInt($('.price').text());
                var old_ids = JSON.parse(localStorage.getItem('recovery_equpment_ids')) || [];

                if ($(this).hasClass('active')) {
                    $(this).removeClass('active');
                    $('.price').text(old_price - price);

                    old_ids = old_ids.filter(function(item) {
                        return item !== id;
                    });
                    localStorage.setItem('recovery_equpment_ids', JSON.stringify(old_ids));

                } else {
                    $(this).addClass('active');
                    $('.price').text(old_price + price);
                    old_ids.push(id);
                    localStorage.setItem('recovery_equpment_ids', JSON.stringify(old_ids));
                }

            });

            // recovery equpments item add
            $('.recovery-add').click(function() {
                var all_ids = JSON.parse(localStorage.getItem('recovery_equpment_ids')) || [];
                $('#addon-select').val('Off Road Recovery Equpment, ' + all_ids.length + ' item');
                $('.recovery-equpment-popup').fadeOut();
                $(this).removeClass('active');
            });



            //recovery equpmentpopup close
            $('.recovery-equpmentpopup_close').click(function() {
                $('.recovery-equpment-popup').fadeOut();
                $(this).removeClass('active');
            });


            //all popup close 
            $('.pupup-close-box').click(function() {
                $('.recovery-equpment-popup').fadeOut();
                $('.add-ons-list-item').removeClass('active');
                $('.optional-equipment').removeClass('active');
                $('.optional-equpment-popup').fadeOut();
                $('.add-ons-list-popup').fadeOut();
                $(this).removeClass('active');
            })
        </script>

        <style>
            .add-ons-list-popup .add-list {
                background: #eee;
                border-radius: 20px;
            }

            .optional-equpment-price {
                background: #fff;
                display: inline-block;
                width: 120px !important;
                padding: 4px 0px !important;
                border-radius: 5px !important;
                text-align: center;
                margin-right: 10px;
            }

            .optional_equipment_item.active,
            .active .optional_equipments_selected i {
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
                color: #ddd;
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
                position: relative;
                border: 1px solid #333;
                border-radius: 20px;
                z-index: 110;
                background: #fff;
                top: -15px;
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
                left: 200px;
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
                width: 90%;
                padding: 0px;
                border-radius: 20px;
                display: none;
                position: relative;
                z-index: 110;
                top: 15px;
            }

            .addon-select-wraper {
                position: relative;
                top: 10px;
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
        </style>

<?php
    }
}
