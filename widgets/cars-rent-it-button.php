<?php
class Elementor_hello_child_cars_rent_it_button extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-rent-it-button';
    }

    public function get_title()
    {
        return esc_html__('cars-rent-it-button', 'elementor-addon');
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
        return ['cars-rent-it-button'];
    }

    protected function render()
    {

?>

        <div class="mb-3">
            <button id="rent-id" data-id="<?php echo get_the_ID(); ?>">Rent it</button>
        </div>
        <div class="error-wraper">
            <div class="error-popup-box">
                <div class="error-massage">
                    <p class="error">massage</p>
                    <span class="close-button">ok</span>
                </div>
            </div>
        </div>

        <script>
            localStorage.removeItem('location_id');
            localStorage.removeItem('tent_id');
            localStorage.removeItem('pick_up_date');
            localStorage.removeItem('pick_up_time');
            localStorage.removeItem('return_date');
            localStorage.removeItem('return_time');

            $('#rent-id').click(function() {
                var id = $(this).data('id');
                var location_id = localStorage.getItem('location_id');
                var tent_id = localStorage.getItem('tent_id');
                var pick_up_date = localStorage.getItem('pick_up_date');
                var pick_up_time = localStorage.getItem('pick_up_time');
                var return_date = localStorage.getItem('return_date');
                var return_time = localStorage.getItem('return_time');

                var date1 = new Date(pick_up_date);
                var date2 = new Date(return_date);

                var timeDifference = date2 - date1;

                var daysDifference = timeDifference / (1000 * 60 * 60 * 24);

                localStorage.setItem('dayes', daysDifference);

                if (location_id == null) {
                    $('.error').text('Please select Pick-Up Location');
                    $('.error-wraper').show();
                } else if (pick_up_date == null) {
                    $('.error').text('Pick-Up Date-Hmm');
                    $('.error-wraper').show();
                } else if (pick_up_time == null) {
                    $('.error').text('Pick-Up Time-Hmm');
                    $('.error-wraper').show();
                } else if (return_date == null) {
                    $('.error').text('Return Date-Hmm');
                    $('.error-wraper').show();
                } else if (return_time == null) {
                    $('.error').text('Return Time-Hmm');
                    $('.error-wraper').show();
                } else if (tent_id == null) {
                    $('.error').text('Please select Tent Type');
                    $('.error-wraper').show();
                } else {
                    localStorage.setItem('car_id', id);
                    window.location.href = "/car-check-out/";
                }

            });

            //all poup close
            $('.error-popup-box').click(function() {
                $('.error-wraper').hide();
            })
        </script>

        <style>
            .error-wraper {
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
                z-index: 110;
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

            #rent-id {
                background: #040404;
                color: #fff;
                border: 0;
                padding: 8px 30px;
                border-radius: 10px;
                font-size: 16px;
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
