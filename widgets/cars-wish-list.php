<?php
class Elementor_hello_child_cars_wish_list extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-wish_list';
    }

    public function get_title()
    {
        return esc_html__('cars-wish_list', 'elementor-addon');
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
        return ['cars-wish_list'];
    }

    protected function render()
    {

?>
        <div class="conteiner">
            <div class="row">
                <div class="brath">
                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/wishlist icon.png" alt="">
                    <h2>Wish List</h2>
                </div>
                <h2 class="page-title">Rent List</h2>
            </div>
            <div class="row" id="lists">

            </div>
        </div>

        <script>
            jQuery(document).ready(function($) {
                var url = '<?php echo admin_url('admin-ajax.php'); ?>';
                var ids = JSON.parse(localStorage.getItem('wish-list')) || [];
                $.ajax({
                    url: url,
                    method: 'get',
                    // dataType: 'json',
                    data: {
                        action: 'get_cars_wish_list',
                        ids
                    },
                    success: function(response) {
                        $('#lists').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });

            });
        </script>

        <style>
            .no-data {
                width: 50%;
                background: #333;
                color: #fff;
                text-align: center;
                margin: auto;
                padding: 65px;
                border-radius: 20px;
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

            .action-button .book-now {
                background-color: #000;
                padding: 10px 40px;
                text-align: center;
                color: #fff;
                border-radius: 10px;
                font-size: 18px;
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
                gap: 30px;
                margin: 30px 0px;
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
