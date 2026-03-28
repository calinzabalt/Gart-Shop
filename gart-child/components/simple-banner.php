<?php
    // Simple banner fallback
    if ( is_shop() || is_product_category() || is_product_tag() ) {
        $title = woocommerce_page_title(false);
    } else {
        $title = get_the_title();
    }
?>

<section class="banner simple-banner">
    <div class="banner_content">
        <div class="container">
            
            <?php if ( ! is_front_page() ) : ?>
                <div class="breadcrumb">
                    <?php if ( function_exists('woocommerce_breadcrumb') ) { woocommerce_breadcrumb(); } ?>
                </div>
            <?php endif; ?>

            <h1 class="banner_title"><?php echo esc_html($title); ?></h1>

        </div>
    </div>
</section>
