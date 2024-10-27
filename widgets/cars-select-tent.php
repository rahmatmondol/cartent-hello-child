<?php
class Elementor_hello_child_cars_select_tent extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-select-tent';
    }

    public function get_title()
    {
        return esc_html__('cars-select-tent', 'elementor-addon');
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
        return ['cars-select-tent'];
    }

    protected function render()
    {

        $args = array(
            'post_type'         => 'product',
            'posts_per_page' => -1,
            'type' => 'tent',
            'post_status' => 'publish',
            'order' => 'ASC'
        );

        $query = new WC_Product_Query($args);
        $tents = $query->get_products();


        $tent_id = get_post_meta(get_the_id(), '_tent', true);
        $product_tent_type =  get_post_meta(get_the_id(), '_tent', true);
        $product_tent_type = json_encode($product_tent_type);

?>

        <div class="mb-3">
            <div class="lavel-group pb-2 mb-2">
                <img class="" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CAR-ROOF-TOP-TENT-TYPE.png" alt="">
                <label for="roof-toop-tent" class="form-label mb-0 m-1">Select Roof Top Tent</label>
            </div>
            <input type="text" class="form-control" id="roof-toop-tent" placeholder="Select Tent Type">
        </div>

        <div class="roof-toop-select-popup" style="display: none;">
            <div class="roof-toop_popup_close">
                <i class="fa fa-times-circle" aria-hidden="true"></i>
            </div>
            <div class="conteiner">
                <div class="row">
                    <?php if ($tents) : ?>
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
                                        <?php foreach ($tents as $tent) : ?>
                                            <tr class="tent-item" data-car_tent_type=<?php echo $product_tent_type; ?> data-type="<?php echo get_post_meta($tent->get_id(), '_tent_type', true); ?>" data-id="<?php echo $tent->get_id(); ?>" data-title="<?php echo $tent->get_name(); ?>">
                                                <td><?php echo $tent->get_name(); ?></td>
                                                <td>
                                                    <?php
                                                    echo get_post_meta($tent->get_id(), '_installation_cost_omr', true) . ' OMR / '
                                                        . get_post_meta($tent->get_id(), '_installation_cost_aud', true) . ' AUD';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo get_post_meta($tent->get_id(), '_10days_omr', true) . ' OMR / '
                                                        . get_post_meta($tent->get_id(), '_10days_aud', true) . ' AUD';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo get_post_meta($tent->get_id(), '_11days_omr', true) . ' OMR / '
                                                        . get_post_meta($tent->get_id(), '_11days_aud', true) . ' AUD';
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    echo get_post_meta($tent->get_id(), '_20days_omr', true) . ' OMR / '
                                                        . get_post_meta($tent->get_id(), '_20days_aud', true) . ' AUD';
                                                    ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-3 tent-image-wrap">
                                <?php foreach ($tents as $tent) : ?>
                                    <div class="tent-image-conten" id="tent-image-<?php echo $tent->get_id(); ?>">
                                        <img id="tent-img" src="<?php echo get_the_post_thumbnail_url($tent->get_id()); ?>" alt="">
                                        <div class="tent-info-box" data-id="<?php echo $tent->get_id(); ?>">
                                            <p>About the Tent</p>
                                            <i class="fa fa-info"></i>
                                        </div>
                                    </div>
                                    <div class="about-tent-popup">
                                        <div class="tent-about-content" id="about-content-<?php echo $tent->get_id(); ?>">
                                            <h4><?php echo $tent->get_name(); ?></h4>
                                            <p><?php echo $tent->get_description(); ?></p>
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

        <div class="error-wraper-tent">
            <div class="error-popup-box">
                <div class="error-massage">
                    <p class="error">massage</p>
                    <span class="close-button">ok</span>
                </div>
            </div>
        </div>

        <script>
            localStorage.setItem('tent_id', <?php echo $tent_id[0]; ?>);
            //all popup close 
            $('.pupup-close-box').click(function() {
                $('.roof-toop-select-popup').fadeOut();
                $(this).removeClass('active');

            })


            //roof toop tent open popup
            $('#roof-toop-tent').on('focus', function() {
                $(this).removeClass('active');
                $('.roof-toop-select-popup').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //roof toop select popup close
            $('.roof-toop_popup_close').click(function() {
                $(this).removeClass('active');
                $('.roof-toop-select-popup').fadeOut();
            });


            //tent select function
            $('.tent-item').on('click', function() {
                var title = $(this).data('title');
                var id = $(this).data('id');
                var image_url = $(this).data('url');
                var tent_type = parseInt($(this).data('type'));
                var car_tent_type = $(this).data('car_tent_type');

                if (car_tent_type !== tent_type) {
                    $('.error').text(title + ' Tents Not applicable');
                    $('.error-wraper-tent').show();
                } else {
                    localStorage.setItem('tent_id', id);
                    $('#roof-toop-tent').val(title);
                }

                $('.tent-item').removeClass('active');
                $(this).addClass('active');

                //set tent image
                $('.tent-image-conten').hide();
                $('#tent-image-' + id).show();

            });

            //error poup close
            $('.error-popup-box').click(function() {
                $('.error-wraper-tent').hide();
            })

            $('.tent-info-box').hover(function() {
                var selector = '#about-content-' + $(this).data('id');
                $(selector).fadeIn();
            });

            $('.tent-info-box').mouseleave(function() {
                var selector = '#about-content-' + $(this).data('id');
                $(selector).fadeOut();
            });
        </script>

        <style>
            .error-wraper-tent {
                display: none;
            }

            .error-popup-box {
                width: 100vw;
                position: fixed;
                height: 100vh;
                background: #0000007d;
                text-align: center;
                top: 0px;
                left: 0;
                z-index: 111;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .error-massage {
                background: #fff;
                width: 400px;
                height: 270px;
                border-radius: 20px;
                padding: 10px;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
            }

            .error-massage .error {
                font-size: 25px;
            }

            .error-massage .close-button {
                position: absolute;
                bottom: 15px;
                right: 15px;
                font-size: 20px;
                color: #08a0b9;
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
                padding: 8px 4px;
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

            .roof-toop-select-popup {
                display: none;
                position: absolute;
                width: 890px;
                border: 1px solid #c1c1c1;
                border-radius: 10px;
                padding: 10px;
                height: fit-content;
                background: #ffffffd9;
                z-index: 110;
                top: 115px;
            }
        </style>

<?php
    }
}
