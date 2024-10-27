<?php

add_action('wp_ajax_get_products_product_wishlist', 'car_product_wishlist');
add_action('wp_ajax_nopriv_get_products_product_wishlist', 'car_product_wishlist');

function car_product_wishlist()
{
    $ids = isset($_GET['ids']) ? $_GET['ids'] : 0;

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => -1,
        'type' => 'variable',
        'post_status' => 'publish',
        'include' => $ids
    );

    $query = new WC_Product_Query($args);
    $products = $query->get_products();

    // echo '<pre>';
    // print_r($products);
    // echo '</pre>';
?>

    <?php if ($products && $ids > 0) : ?>

        <?php foreach ($products as $product) : ?>
            <div class="col-lg-4">
                <img class="car-image" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'large') ?>" alt="<?php echo $product->get_name(); ?>">
                <div class="price-box">
                    <p>
                        <?php echo $product->get_name(); ?>
                    </p>
                    <p>
                        <?php
                        $sizes = get_children(array(
                            'post_parent' => $product->get_id(),
                            'post_type'   => 'product_variation',
                        ));
                        ?>
                        <?php foreach ($sizes as $size) {
                        }
                        echo get_post_meta($size->ID, '_price', true); ?>

                    </p>
                </div>

                <div class="options">
                    <div class="size">
                        <select class="form-select size" name="size" data-id="<?php echo $product->get_id(); ?>" aria-label="Default select example">
                            <option selected>Select Size</option>
                            <?php foreach ($sizes as $size) : $result = str_replace($product->name . ' - ', "", $size->post_title); ?>
                                <option value="<?php echo $size->ID; ?>"><?php echo $result; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="quantity">
                        <select class="form-select quantity" name="qty" data-id="<?php echo $product->get_id(); ?>" aria-label="Default select example">
                            <option selected value="0">Select Quantity</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                        </select>
                    </div>
                </div>
                <div class="description">
                    <p><?php echo $product->get_description(); ?></p>
                </div>
                <div class="action-button" style="gap: 20px;">
                    <div>
                        <a class="add-to-cart" id="cart-<?php echo $product->get_id(); ?>" data-qty="" data-size="" data-id="<?php echo $product->get_id(); ?>">Add to Cart <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/img/CART-ICON.png" alt=""></a>
                    </div>
                    <div>
                        <a href="<?php echo site_url(); ?>/shop" class="favourite">Back to Shop</a>
                    </div>
                </div>
            </div>
            <div class="error-wraper">
                <div class="error-popup-box">
                    <div class="error-massage">
                        <p class="error">massage</p>
                        <span class="close-button">ok</span>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else : ?>
        <div class="col">
            <div class="no-data">
                <h3>No Wishlist available</h3>
            </div>
        </div>
    <?php endif; ?>


<?php
    exit;
}
