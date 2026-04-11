<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );
?>

<div class="single_product_wrapper">
    <div class="container">
        <?php do_action( 'woocommerce_before_main_content' ); ?>

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
