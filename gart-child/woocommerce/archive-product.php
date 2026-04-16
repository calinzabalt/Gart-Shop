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
        <?php
        $auction_args = array(
            'post_type'      => 'product',
            'posts_per_page' => 1,
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_type',
                    'field'    => 'slug',
                    'terms'    => 'auction',
                ),
            ),
        );
        $auctions = new WP_Query( $auction_args );

        if ( $auctions->have_posts() && is_shop() && !is_paged() ) :
            while ( $auctions->have_posts() ) : $auctions->the_post();
                global $product;
                $end_date = get_post_meta( get_the_ID(), '_auction_end_date', true );
                $current_bid = get_post_meta( get_the_ID(), '_auction_current_bid', true ) ?: get_post_meta( get_the_ID(), '_auction_start_price', true );
                ?>
                <div class="shop-auction-advert">
                    <div class="auction-advert-content flex item-center">
                        <div class="auction-advert-image">
                            <?php the_post_thumbnail('large'); ?>
                        </div>
                        <div class="auction-advert-text">
                            <span class="advert-label"><?php _e('LICITAȚIE ACTIVĂ', 'gart-auction'); ?></span>
                            <h2><?php the_title(); ?></h2>
                            <p class="advert-description"><?php echo wp_trim_words( get_the_content(), 35, '...' ); ?></p>
                            
                            <div class="advert-meta flex">
                                <div class="meta-item">
                                    <span class="label"><?php _e('Bid curent:', 'gart-auction'); ?></span>
                                    <span class="value"><?php echo wc_price($current_bid); ?></span>
                                </div>
                                <div class="meta-item">
                                    <span class="label"><?php _e('Se încheie în:', 'gart-auction'); ?></span>
                                    <span class="value auction-timer-mini" data-end="<?php echo esc_attr($end_date); ?>">--:--:--</span>
                                </div>
                            </div>

                            <div class="advert-bidding-form">
                                <?php if ( time() < strtotime($end_date) ): ?>
                                    <?php 
                                    $min_bid = $current_bid + (get_post_meta(get_the_ID(), '_auction_bid_increment', true) ?: 1);
                                    $login_class = !is_user_logged_in() ? ' login-link' : '';
                                    ?>
                                    <div class="bid-form flex item-center" style="gap:10px; margin-bottom: 10px;">
                                        <input type="number" id="bid-amount" step="any" min="<?php echo esc_attr($min_bid); ?>" value="<?php echo esc_attr($min_bid); ?>" style="width: 100px; padding: 12px; height: 48px; border: 1px solid #ddd;">
                                        <button type="button" id="place-bid-btn" data-product-id="<?php the_ID(); ?>" class="button alt <?php echo $login_class; ?>" style="margin: 0; flex: 1; height: 48px;"><?php _e('Plasează Bid', 'gart-auction'); ?></button>
                                    </div>
                                    <div id="bid-message"></div>
                                <?php endif; ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="view-details-link"><?php _e('Vezi detalii produs', 'gart-auction'); ?></a>
                        </div>
                    </div>
                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        endif;
        ?>

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
