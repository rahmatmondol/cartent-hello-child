<?php
class Elementor_hello_child_cars_checkout_page extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-checkout-page';
    }

    public function get_title()
    {
        return esc_html__('cars-checkout-page', 'elementor-addon');
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
        return ['cars-checkout-page'];
    }


    protected function render()
    {


?>

        <div id="main">

        </div>

        <script>
            var url = '<?php echo admin_url('admin-ajax.php'); ?>';
            var site_url = '<?php echo site_url(); ?>';
            var location_id = localStorage.getItem('location_id');
            var total_days = localStorage.getItem('dayes');
            var tent_id = localStorage.getItem('tent_id');
            var pick_up_date = localStorage.getItem('pick_up_date');
            var pick_up_time = localStorage.getItem('pick_up_time');
            var return_date = localStorage.getItem('return_date');
            var return_time = localStorage.getItem('return_time');
            var car_id = localStorage.getItem('car_id') || false;
            var add_ons_recovery = JSON.parse(localStorage.getItem('recovery_equpment_ids'));
            var add_ons_optional = JSON.parse(localStorage.getItem('optional_equpment_ids'));

            jQuery(document).ready(function($) {
                if (car_id !== false) {
                    $.ajax({
                        url: url,
                        method: 'get',
                        // dataType: 'json',
                        data: {
                            action: 'get_cars_checkout_page',
                            location_id,
                            tent_id,
                            car_id,
                            add_ons_recovery,
                            add_ons_optional,
                            pick_up_date,
                            pick_up_time,
                            return_date,
                            return_time,
                            total_days,
                        },
                        success: function(response) {
                            $('#main').html(response);
                            $('#order_add_to_cart').submit(function(e) {
                                e.preventDefault();
                                add_to_cart_event();
                            })
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', status, error);
                        }
                    });
                } else {
                    document.location.href = site_url + '/choose-your-car/';
                }

                function add_to_cart_event() {
                    $.ajax({
                        url: url,
                        method: 'post',
                        dataType: 'json',
                        data: {
                            action: 'car_add_to_cart',
                            location_id,
                            tent_id,
                            car_id,
                            add_ons_recovery,
                            add_ons_optional,
                            pick_up_date,
                            pick_up_time,
                            return_date,
                            return_time,
                            total_days,

                        },
                        success: function(response) {
                            if (response) {
                                location.href = '<?php echo site_url(); ?>/checkout/'
                            }
                        },
                        error: function(xhr, status, error) {
                            console.log('Error:', status, error);
                        }
                    });
                }


            });
        </script>

        <style>
            .boking-details .details {
                display: flex;
                align-items: center;
                gap: 72px;
                border-radius: 13px;
            }

            #above-22 {
                padding: 19px;
                width: 85px;
                background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/toggle.png ?>");
                background-color: #969695;
            }

            #above-22:checked {
                background-color: #4ba473;
                border-color: #4ba473;
            }

            .submit-button {
                text-align: right;
            }

            .submit-button .submit {
                border: 0px;
                background: #000;
                color: #fff;
                padding: 10px 35px;
                border-radius: 10px;
            }

            .policy {
                padding: 20px 0px;
                display: flex;
                flex-flow: column;
                gap: 20px;
            }

            .policy p {
                font-size: 16px;
                line-height: 20px;
            }

            .policy p br {
                margin: 10px;
            }

            .policy .readmore {
                background: #e0dede;
                padding: 10px 20px;
                border-radius: 10px;
                color: #333;
                align-self: start;
            }

            .policy .form-check {
                display: flex;
                align-items: center;
                gap: 10px;
            }

            .policy .form-check input {
                padding: 12px;
            }

            .form-input-upload .form-label {
                background: #404040;
                color: #c1c1c1;
                padding: 20px 60px;
                border-radius: 17px;
                position: absolute;
                cursor: pointer;
                font-size: 20px;
            }

            .form-input-upload {
                position: relative;
            }

            .form-input-upload input {
                height: 50px;
                border: 0px solid #fff0;
                color: #bfbfbf;
                padding: 16px 14px 0 127px;
                font-size: 18px;
            }

            .age-note {
                padding: 20px;
            }

            .form-input {
                padding: 10px 20px;
            }

            .form-input input {
                border-radius: 15px;
                height: 60px;
                border-color: #ddd;
            }

            .form-input label {
                font-size: 16px;
            }

            .sumary.toggle {
                color: #777;
            }

            #billing-togle:checked {
                background-color: #4ba473;
                border-color: #4ba473;
            }

            #billing-togle {
                padding: 19px;
                width: 85px;
                background-image: url("<?php echo get_stylesheet_directory_uri(); ?>/assets/img/toggle.png ?>");
                background-color: #969695;
            }

            .sumary-note {
                padding: 10px;
                margin: 10px 10px;
            }

            .line-vertical {
                border: 1px solid #ddd;
                height: 320px;
                display: block;
                width: 1px;
                position: absolute;
                top: 0;
                right: 0;
            }

            .details {
                display: flex;
                justify-content: space-between;
            }

            .details p {
                margin: 0;
            }

            .boking-details {
                margin: 0px 0px;
                padding-right: 30px;
            }

            .boking-details>p {
                margin: 0;
            }

            .details p span {
                font-size: 90%;
                color: #757575;
            }

            .sumary.grand-totol {
                background: #333 !important;
                color: #fff;
            }

            .sumary {
                background: #eee;
                padding: 12px 20px;
                border-radius: 20px;
                font-size: 18px;
                color: #000;
                margin-bottom: 10px;
            }

            .days {
                display: flex;
                justify-content: space-between;
                padding-right: 30px;
            }

            .days>p {
                margin-bottom: 25px;
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

            .line {
                margin: 50px 0px !important;
            }

            .car-detals {
                padding: 5px;
            }

            .selected-options {
                display: flex;
                flex-flow: column;
                justify-content: center;
                padding-left: 30px;
            }

            .title {
                font-size: 28px;
            }

            .car-image {
                object-position: center center;
                border-radius: 30px !important;
                box-shadow: -2px 5px 6px 1px rgba(0, 0, 0, 0.33) !important;
            }

            .car-detals p {
                font-size: 14px;
                color: #f00000;
                margin-left: 40px;
                margin-bottom: 0;
            }

            .car-detals .heading {
                display: flex;
                align-items: center;
            }

            .car-detals .heading img {
                width: 36px;
                display: inline-block;
            }

            .car-detals .heading h3 {
                display: inline-block;
                margin: 0px 5px;
                font-size: 16px;
            }
        </style>

<?php
    }
}
