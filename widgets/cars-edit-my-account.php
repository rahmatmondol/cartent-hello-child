<?php
class Elementor_hello_child_cars_edit_my_account extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-edit-my-account';
    }

    public function get_title()
    {
        return esc_html__('cars-edit-my-account', 'elementor-addon');
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
        return ['cars-edit-my-account'];
    }


    protected function render()
    {
        $user_id = get_current_user_id();
        $user_mail = get_userdata($user_id);

?>

        <div class="conteiner">
            <div class="row">
                <div class="brath">
                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/edit my account icon.png" alt="">
                    <h2>Edit My Account</h2>
                </div>
            </div>
            <form action="<?php echo admin_url('admin-post.php'); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="car_edit_my_account_handaler">
                <div class="row">
                    <div class="col-3">
                        <div class="profile-uploader">
                            <?php if (get_user_meta($user_id, 'profile', true)) : ?>
                                <img class="my-account-avater" src="<?php echo get_user_meta($user_id, 'profile', true); ?>" alt="">
                            <?php else : ?>
                                <img class="my-account-avater" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my-account-avatar.jpeg" alt="">
                            <?php endif; ?>
                            <label for="profile"><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/camera icon.png" alt=""></label>
                            <input type="file" name="profile" id="profile">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first-name" name="first-name" value="<?php echo get_user_meta($user_id, 'first_name', true); ?>" placeholder="Enter First Name" required>
                            <span>*John</span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="Last-name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="Last-name" name="last-name" value="<?php echo get_user_meta($user_id, 'last_name', true); ?>" placeholder="Enter First Name" required>
                            <span>*Doe</span>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="contact_number" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contact_number" name="contact-number" value="<?php echo get_user_meta($user_id, 'contact_number', true); ?>" placeholder="Enter Contact Number" required>
                            <span>*968 91234366</span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($user_mail->data) ? $user_mail->data->user_email : ''; ?>" placeholder="Enter Email Addresse" required>
                            <span>*johndoe@gmail.ocm</span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-select form-select-lg mb-3" name="gender" id="gender" aria-label="Large select example">
                                <option <?php echo get_user_meta($user_id, 'gender', true) == '' ? 'selected' : ''; ?> disabled></option>
                                <option <?php echo get_user_meta($user_id, 'gender', true) == 'male' ? 'selected' : ''; ?> value="male">male</option>
                                <option <?php echo get_user_meta($user_id, 'gender', true) == 'female' ? 'selected' : ''; ?> value="female">female</option>
                            </select>
                            <span>*male</span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="mb-3 form-input">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Set Password" required>
                            <span>*Password</span>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <div class="age-note">
                            <p>Age Above 22 ?</p>
                            <div class="sumary toggle">
                                <div class="boking-details">
                                    <div class="details">
                                        <p>I here by confirm that the driver age is
                                            above 22 years</p>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" value="1" id="above-22" name="above-22" <?php echo get_user_meta($user_id, 'above_22', true) ? 'checked' : ''; ?>>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-5"></div>

                </div>
                <hr class="line">
                <div class="row">
                    <h2>Upload Verification Documents</h2>
                    <div class="col-lg-5">
                        <p class="label">Driver's License</p>
                        <div class="mb-3 form-input-upload">
                            <label for="license" class="form-label">Choose File</label>
                            <input type="file" class="form-control" id="license" name="license">
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <p class="label">Driver's Passport</p>
                        <div class="mb-3 form-input-upload">
                            <label for="passport" class="form-label">Choose File</label>
                            <input type="file" class="form-control" id="passport" name="passport">
                        </div>
                    </div>
                </div>
                <hr class="line">
                <div class="row relative">
                    <h2>Your Payment Mehtod</h2>
                    <span class="no-payment">*No Payment select</span>
                    <div class="col-lg-5">
                        <div class="mb-3 payment-methods">
                            <ul class="payment-list">
                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/gpay.png" alt=""></li>
                                <li><img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/paypal.png" alt=""></li>
                            </ul>
                        </div>
                    </div>
                    <div class="submit-button">
                        <button type="submit" name="submit" class="submit">Save</button>
                    </div>
                </div>
            </form>
        </div>

        <script src="https://sparkgarage-oman.com/wp-content/themes/chromium/woocommerce/intl-tel-input-master/build/js/intlTelInput.js"></script>
        <script>
            var url = '<?php echo admin_url('admin-ajax.php'); ?>';
            var site_url = '<?php echo site_url(); ?>';

            var input = document.querySelector("#contact_number");
            window.intlTelInput(input, {
                initialCountry: "om",
                separateDialCode: true,
                utilsScript: "build/js/utils.js"
            });
        </script>
        <link rel="stylesheet" href="https://sparkgarage-oman.com/wp-content/themes/chromium/woocommerce/intl-tel-input-master/build/css/intlTelInput.css" />
        <link rel="stylesheet" href="/https://sparkgarage-oman.com/wp-content/themes/chromium/woocommerce/intl-tel-input-masterbuild/css/demo.css" />
        <style>
            .relative {
                position: relative;
            }

            .no-payment {
                position: absolute;
                left: 365px;
                top: 12px;
                font-size: 14px;
            }

            .submit-button {
                text-align: right;
            }

            .submit-button .submit {
                border: 0px;
                background: #515151;
                color: #fff;
                padding: 10px 30px;
                border-radius: 10px;
            }

            .payment-list li img {
                width: 100px;
            }

            .payment-list li {
                display: inline-block;
                padding-right: 60px;
                opacity: 0.5;
            }

            .payment-list li:hover {
                opacity: 1;
            }

            .payment-list {
                padding: 0px;
            }

            #gender {
                margin: 0 !important;
                border-radius: 13px;
                height: 60px;
                font-size: 16px;
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


            .boking-details .details {
                background: #ececec;
                display: flex;
                padding: 10px 20px;
                align-items: center;
                gap: 72px;
                border-radius: 13px;
            }

            .profile-uploader {
                position: relative;
                margin-bottom: 80px;
            }

            .profile-uploader label img {
                width: 40px;
                position: absolute;
                bottom: 0;
                left: 172px;
                cursor: pointer;
            }

            .my-account-avater {
                width: 180px;
                border-radius: 20px !important;
            }

            .profile-uploader input {
                display: none;
            }


            #country-select {
                width: 81px;
                height: 40px;
                border: 0px;
                background-size: 10px;
                background-position-x: 67px;
                border-radius: 0px;
                float: right;
                position: absolute;
                right: 0;
                top: -5px;
            }

            .iti__country-name {
                display: none;
            }

            .iti__flag-container {
                top: -26px;
                width: 100px;
                height: 20px;
                left: 80% !important;
            }

            .iti.iti--allow-dropdown.iti--show-flags {
                width: 100%;
            }

            .iti__selected-flag {
                background: transparent !important;
            }

            #contact_number {
                padding-left: 25px !important;
            }

            .iti__arrow {
                margin-left: 8px;
                width: 0;
                height: 0;
                border-left: 3px solid transparent;
                border-right: 3px solid transparent;
                border-top: 7px solid #555;
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


            .form-input-upload .form-label {
                background: #333;
                color: #fff;
                padding: 15px 20px;
                border-radius: 10px;
                position: absolute;
                cursor: pointer;
            }

            .form-input-upload {
                position: relative;
            }

            .form-input-upload input {
                height: 45px;
                border: 0px solid #fff0;
                color: #bfbfbf;
                padding: 10px 40px;
                font-size: 17px;
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

            .line-vertical {
                border: 1px solid #ddd;
                height: 320px;
                display: block;
                width: 1px;
                position: absolute;
                top: 0;
                right: 0;
            }

            .line {
                margin: 50px 0px !important;
            }


            .title {
                font-size: 28px;
            }

            .brath {
                display: flex;
                justify-content: start;
                align-items: center;
                margin: 40px 0px;
            }

            .brath img {
                width: 31px;
                height: fit-content;
            }

            .brath h2 {
                font-size: 34px;
            }
        </style>

<?php
    }
}
