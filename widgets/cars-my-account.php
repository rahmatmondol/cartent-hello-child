<?php
class Elementor_hello_child_cars_my_accout extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-my-accout';
    }

    public function get_title()
    {
        return esc_html__('cars-my-accout', 'elementor-addon');
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
        return ['cars-my-accout'];
    }


    protected function render()
    {

        $user_id = get_current_user_id();
        $user_mail = get_userdata($user_id);

?>

        <div class="conteiner">
            <div class="row">
                <div class="col-lg-5 relative">
                    <div class="account-nav">
                        <ul>
                            <li>
                                <a href="<?php echo site_url(); ?>/my-account-2/">
                                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my account icon.png" alt="">
                                    <p class="active">My Account</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url(); ?>/edit-my-account/">
                                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/edit my account icon.png" alt="">
                                    <p>Edit My Account</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url(); ?>/order-history/">
                                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
                                    <p>Order History</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo site_url(); ?>/wish-list/">
                                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wishlist icon.png" alt="">
                                    <p>Wish List</p>
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo wp_logout_url(); ?>">
                                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/log out icon.png" alt="">
                                    <p>Log Out</p>
                                </a>
                            </li>
                        </ul>
                        <hr class="line">
                    </div>

                </div>
                <div class="col-lg-5">
                    <div class="profile">
                        <?php if (get_user_meta($user_id, 'profile', true)) : ?>
                            <img class="my-account-avater" src="<?php echo get_user_meta($user_id, 'profile', true); ?>" alt="">
                        <?php else : ?>
                            <img class="my-account-avater" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/my-account-avatar.jpeg" alt="">
                        <?php endif; ?>
                        <p>Hello <?php echo get_user_meta($user_id, 'first_name', true); ?></p>
                        <p><?php echo isset($user_mail->data) ? $user_mail->data->user_email : ''; ?></p>
                    </div>
                </div>
            </div>
        </div>



        <style>
            .account-nav .active {
                font-size: 22px;
                font-weight: 600;
            }

            .profile img {
                border-radius: 20px;
                width: 150px;
                margin-bottom: 10px;
            }

            .profile p {
                padding: 0;
                margin: 0;
                color: #575757;
            }

            .account-nav ul img {
                width: 30px;
            }

            .account-nav ul li {
                list-style: none;
            }

            .account-nav ul img {
                display: inline-block;
            }

            .account-nav ul p {
                display: inline-block;
                padding: 3px 3px;
                color: #000;
            }

            .account-nav ul p:hover {
                color: #bdbdbd;
            }

            .line {
                background-color: #000 !important;
                height: 3px;
                rotate: 90deg;
                width: 270px;
                position: absolute;
                right: -100px;
                top: 132px;
            }

            .account-nav {
                position: relative;
            }
        </style>

<?php
    }
}
