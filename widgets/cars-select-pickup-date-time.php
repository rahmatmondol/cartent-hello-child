<?php
class Elementor_hello_child_cars_pickup_date_time extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-pickup-date-time';
    }

    public function get_title()
    {
        return esc_html__('cars-pickup-date-time', 'elementor-addon');
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
        return ['cars-pickup-date-time'];
    }

    protected function render()
    {

?>

        <div class="mb-3">
            <div class="row">
                <div class="col-12 col-lg-6" style="position: relative;">
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
                        <input type="text" class="form" id="pick-up-date">
                        <input type="text" class="form" id="pick-up-time">
                    </div>
                    <div class="select-time" id="pick-up-time-select">
                        <p>Pick-Up Time</p>
                        <ul>
                            <li class="time-select">00:00</li>
                            <li class="time-select">00:30</li>
                            <li class="time-select">01:00</li>
                            <li class="time-select">01:30</li>
                            <li class="time-select">02:00</li>
                            <li class="time-select">02:30</li>
                            <li class="time-select">03:00</li>
                            <li class="time-select">03:30</li>
                            <li class="time-select">04:00</li>
                            <li class="time-select">04:30</li>
                            <li class="time-select">05:00</li>
                            <li class="time-select">05:30</li>
                            <li class="time-select">06:00</li>
                            <li class="time-select">06:30</li>
                            <li class="time-select">07:00</li>
                            <li class="time-select">07:30</li>
                            <li class="time-select">08:00</li>
                            <li class="time-select">08:30</li>
                            <li class="time-select">09:00</li>
                            <li class="time-select">09:30</li>
                            <li class="time-select">10:00</li>
                            <li class="time-select">10:30</li>
                            <li class="time-select">11:00</li>
                            <li class="time-select">11:30</li>
                            <li class="time-select">12:00</li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-lg-6 mt-4 mt-lg-0" style="position: relative;">
                    <div class="lavel-group w-100 pb-2">
                        <div class="row">
                            <div class="col-6">
                                <img class="d-inline-block" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/calender  icon.png" alt="">
                                <label for="return-location" class="form-label">Return Date <span class="text-danger">*</span></label>
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

                    <div class="select-time" id="return-time-select">
                        <p>Return Time</p>
                        <ul>
                            <li class="time-select">00:00</li>
                            <li class="time-select">00:30</li>
                            <li class="time-select">01:00</li>
                            <li class="time-select">01:30</li>
                            <li class="time-select">02:00</li>
                            <li class="time-select">02:30</li>
                            <li class="time-select">03:00</li>
                            <li class="time-select">03:30</li>
                            <li class="time-select">04:00</li>
                            <li class="time-select">04:30</li>
                            <li class="time-select">05:00</li>
                            <li class="time-select">05:30</li>
                            <li class="time-select">06:00</li>
                            <li class="time-select">06:30</li>
                            <li class="time-select">07:00</li>
                            <li class="time-select">07:30</li>
                            <li class="time-select">08:00</li>
                            <li class="time-select">08:30</li>
                            <li class="time-select">09:00</li>
                            <li class="time-select">09:30</li>
                            <li class="time-select">10:00</li>
                            <li class="time-select">10:30</li>
                            <li class="time-select">11:00</li>
                            <li class="time-select">11:30</li>
                            <li class="time-select">12:00</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="pupup-close-box"></div>

        <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
        <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
        <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

        <script>
            //date picker function
            $(function() {
                var dateFormat = "mm/dd/yy",
                    from = $("#pick-up-date")
                    .datepicker({
                        defaultDate: "+1w",
                        numberOfMonths: 1
                    })
                    .on("change", function() {
                        to.datepicker("option", "minDate", getDate(this));
                        localStorage.setItem('pick_up_date', this.value);
                    }),
                    to = $("#return-date").datepicker({
                        defaultDate: "+1w",
                        numberOfMonths: 1
                    })
                    .on("change", function() {
                        from.datepicker("option", "maxDate", getDate(this));
                        localStorage.setItem('return_date', this.value);
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

            //pick up time select
            $('#pick-up-time-select .time-select').click(function() {
                var value = $(this).text();
                $('.time-select').removeClass('active');
                $(this).addClass('active');
                $('#pick-up-time').val(value);
                localStorage.setItem('pick_up_time', value);
                $('#pick-up-time-select').fadeOut();
                $(this).removeClass('active');
            });

            //return time select
            $('#return-time-select .time-select').click(function() {
                var value = $(this).text();
                $('.time-select').removeClass('active');
                $(this).addClass('active');
                $('#return-time').val(value);
                localStorage.setItem('return_time', value);
                $('#return-time-select').fadeOut();
                $(this).removeClass('active');
            });

            //pick up time popup open
            $('#pick-up-time').on('focus', function() {
                $('#pick-up-time-select').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //return time popup open
            $('#return-time').on('focus', function() {
                $('#return-time-select').fadeIn();
                $('.pupup-close-box').addClass('active');
            });

            //all poup close
            $('.pupup-close-box').click(function() {
                $('#pick-up-time-select').fadeOut();
                $('#return-time-select').fadeOut();
                $(this).removeClass('active');
            })
        </script>

        <style>
            .ui-state-default.ui-state-highlight {
                background: #000;
                color: #fff;
            }

            .select-time {
                position: absolute;
                z-index: 110;
                border: 1px solid #333;
                border-radius: 20px;
                padding: 10px;
                width: 130px;
                top: 111px;
                left: 50%;
                background: #fff;
                display: none;
            }

            .select-time ul li {
                list-style: none;
                display: block;
                padding: 0px 8px;
                font-size: 18px;
                cursor: pointer;
                border-radius: 2px;
                margin: 5px 5px;
            }

            .select-time ul li:hover {
                background: #333;
                color: #fff;
            }

            .select-time ul li.active {
                background: #333;
                color: #fff;
            }

            .select-time ul {
                padding: 0px;
                height: 200px;
                overflow: scroll;
                margin-right: 20px;
            }

            .select-time p {
                margin: 5px 10px;
                font-size: 18px;
            }

            #ui-datepicker-div {
                border-radius: 20px;
                padding: 12px;
                background: #fbfbfbe5;
                margin-top: 5px;
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
