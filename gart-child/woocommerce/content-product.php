<?php
defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product || ! $product->is_visible() ) {
    return;
}
?>

<li <?php wc_product_class( '', $product ); ?>>

    <a href="<?php echo esc_url( get_permalink() ); ?>" class="product-link">
        <div class="overlay"></div>
        <div class="product-inner">

            <?php do_action( 'woocommerce_before_shop_loop_item_title' ); ?>

            <div class="product_bottom">
                <h2 class="woocommerce-loop-product__title">
                    <?php the_title(); ?>
                </h2>

                <?php
                $categories = get_the_terms( get_the_ID(), 'product_cat' );
                if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
                    $first_cat = $categories[0]->name;
                    echo '<div class="product-category-name">' . esc_html( $first_cat ) . '</div>';
                }
                ?>

                <div class="price-wrapper">
                    <?php woocommerce_template_loop_price(); ?>
                </div>
            </div>

        </div>

    </a>

    <?php do_action( 'woocommerce_after_shop_loop_item' ); ?>

</li>