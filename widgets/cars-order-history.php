<?php
class Elementor_hello_child_cars_order_history extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'cars-order_history';
    }

    public function get_title()
    {
        return esc_html__('cars-order_history', 'elementor-addon');
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
        return ['cars-order_history'];
    }


    protected function render()
    {
        $user_id = get_current_user_id();

        $orders = wc_get_orders(array(
            'customer' => $user_id,
            'posts_per_page' => -1,
        ));

        $pages = 1;
        foreach ($orders as $order) {
            $pages++;
        }

        $pages = $pages / 2;
        $pages = round($pages);


?>
        <div class="conteiner">
            <div class="row">
                <div class="brath">
                    <img class="brath-image" src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/order history icon.jpg" alt="">
                    <h2>Order History</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-10 m-auto">
                    <?php if ($user_id) : ?>
                        <?php if ($orders) : ?>
                            <div class="order-history-wraper">
                                <table class="tent-list-table">
                                    <thead>
                                        <tr>
                                            <td>Order Number</td>
                                            <td>Order Date</td>
                                            <td>Order Details</td>
                                            <td>Order Location</td>
                                            <td>Payment Method</td>
                                        </tr>
                                    </thead>
                                    <tbody id="table-content">

                                    </tbody>
                                </table>
                                <?php if ($pages > 1) : ?>
                                    <div class="paginate">
                                        <ul>
                                            <?php for ($i = 0; $i < $pages; $i++) : ?>
                                                <li class="paginate-item <?php echo $i == 0 ? 'active' : ''; ?>" data-page="<?php echo $i + 1; ?>"><?php echo $i + 1; ?> </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else : ?>
                            <div class="no-data">
                                <h3>Currently No Orders Have Been Placed</h3>
                            </div>
                        <?php endif; ?>
                    <?php else : ?>
                        <div class="no-data">
                            <h3>Currently No Orders Have Been Placed</h3>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <script>
            var url = '<?php echo admin_url('admin-ajax.php'); ?>';
            jQuery(document).ready(function($) {

                $('.paginate-item').click(function() {
                    $('.paginate-item').removeClass('active');
                    $(this).addClass('active');
                    var page = $(this).data('page');

                    $.ajax({
                        url: url,
                        method: 'get',
                        // dataType: 'json',
                        data: {
                            action: 'get_cars_order_history',
                            page
                        },
                        success: function(response) {
                            $('#table-content').html(response);
                        },
                        error: function(xhr, status, error) {
                            console.error('Error:', status, error);
                        }
                    });
                });

                $.ajax({
                    url: url,
                    method: 'get',
                    // dataType: 'json',
                    data: {
                        action: 'get_cars_order_history',
                        page: 1,
                    },
                    success: function(response) {
                        $('#table-content').html(response);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', status, error);
                    }
                });
            });
        </script>

        <style>
            .no-data h3 {
                font-size: 20px;
            }

            .no-data {
                width: 55%;
                margin: 0 auto;
                background: #333;
                color: #fff;
                height: 160px;
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 20px;
            }

            .paginate-item.active {
                background: #333;
                border-color: #333;
                color: #fff;
            }

            .paginate {
                text-align: right;
            }

            .paginate ul li {
                list-style: none;
                padding: 5px 20px;
                display: inline-block;
                background: #f2f2f2;
                color: #000;
                font-size: 22px;
                border: 1px solid #b9b9b9;
                cursor: pointer;
                margin: 5px;
                border-radius: 10px;
            }

            .tent-list-table tbody tr td a {
                display: block;
                text-align: right;
                font-size: 14px;
                color: #1b7d99;
            }

            .tent-item td span {
                color: #828282;
                font-size: 15px;
            }

            .order-history-wraper {
                border-radius: 20px;
                box-shadow: -5px 5px 10px 10px #ddd;
                padding: 20px;
            }

            .tent-list-table thead tr td {
                padding: 10px;
                background: #333;
                color: #fff;
                font-size: 15px;
            }

            .tent-list-table tbody {
                font-size: 14px;
            }

            .tent-list-table tbody tr td {
                padding: 14px 10px;
                border: 1px solid #fff;
                font-size: 16px;
            }

            .tent-list-table {
                border-collapse: separate;
                border-spacing: 2px 2px;
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
