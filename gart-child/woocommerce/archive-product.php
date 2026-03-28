<?php
defined( 'ABSPATH' ) || exit;

get_header( 'shop' );

if ( is_shop() ) {
    $context = wc_get_page_id('shop');
} elseif ( is_tax() || is_category() || is_tag() ) {
    $context = get_queried_object();
} else {
    $context = get_the_ID();
}

if ( get_field('title', $context) ) {
    get_template_part('components/page-banner');
} else {
    get_template_part('components/simple-banner');
}

do_action( 'woocommerce_before_main_content' );
?>

<section class="shop-container">
    <div class="container">
        <div class="shop-flex flex">
            
            <div class="left_filters">
                <?php get_template_part( 'inc/shop-filters' ); ?>
            </div>

            <div class="right_products">
                <div class="site-main">
                    <div class="woocommerce-content">
                        <?php
                        if ( woocommerce_product_loop() ) {
                            do_action( 'woocommerce_before_shop_loop' );

                            woocommerce_product_loop_start();

                            if ( wc_get_loop_prop( 'total' ) ) {
                                while ( have_posts() ) {
                                    the_post();
                                    do_action( 'woocommerce_shop_loop' );
                                    wc_get_template_part( 'content', 'product' );
                                }
                            }

                            woocommerce_product_loop_end();

                            do_action( 'woocommerce_after_shop_loop' );
                        } else {
                            do_action( 'woocommerce_no_products_found' );
                        }
                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<?php do_action( 'woocommerce_after_main_content' ); ?>

<?php get_footer(); ?>
