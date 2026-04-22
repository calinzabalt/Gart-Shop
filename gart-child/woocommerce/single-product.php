<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
?>

<div class="single_product_wrapper">
    <div class="container standard-width">
        <a href="javascript:history.back()" class="go-back">
            <svg width="10" height="8" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M17 7H1M1 7L7 13M1 7L7 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Înapoi
        </a>
        <?php do_action( 'woocommerce_before_main_content' ); ?>
    </div>

    <div class="container">
        <?php while ( have_posts() ) : ?>
            <?php the_post(); ?>
            <?php wc_get_template_part( 'content', 'single-product' ); ?>
        <?php endwhile; ?>

        <?php do_action( 'woocommerce_after_main_content' ); ?>
    </div>
</div>

<div class="container related-products-wrapper">
    <?php woocommerce_output_related_products(); ?>
</div>

<?php get_footer( 'shop' ); ?>
