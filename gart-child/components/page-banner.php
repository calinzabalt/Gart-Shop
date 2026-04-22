<?php
    if ( is_shop() ) {
        $context = wc_get_page_id('shop');
    } elseif ( is_tax() || is_category() || is_tag() ) {
        $context = get_queried_object();
    } else {
        $context = get_the_ID();
    }
    
    $title = get_field('title', $context);
    $description = get_field('description', $context);
    $button = get_field('button', $context);
    $button_title = is_array($button) && isset($button['title']) ? $button['title'] : '';
    $button_link = is_array($button) && isset($button['url']) ? $button['url'] : '';
    $overlay = get_field('overlay', $context);
    $bg_image_id = get_field('background_image', $context);
    $video = get_field('video', $context);
?>

<section class="banner">
    <?php if ( $video ) : ?>
        <video class="banner_video" autoplay loop muted playsinline poster="<?php echo wp_get_attachment_image_url( $bg_image_id, 'full' ); ?>">
            <source src="<?php echo is_array($video) ? $video['url'] : $video; ?>" type="video/mp4">
        </video>
    <?php else : ?>
        <?php echo wp_get_attachment_image( $bg_image_id, 'full' ); ?>
    <?php endif; ?>

    <div class="banner_content">
        <div class="container">
            <?php if ( $video ) : ?>
                <h1 class="screen-reader-text"><?php echo $title; ?></h1>
            <?php else : ?>
                <?php if ( ! is_front_page() ) : ?>
                    <div class="breadcrumb">
                        <?php if ( function_exists('woocommerce_breadcrumb') ) { woocommerce_breadcrumb(); } ?>
                    </div>
                <?php endif; ?>

                <h1 class="banner_title"><?php echo $title; ?></h1>

                <?php if(!empty($description)): ?>
                    <p class="banner_description"><?php echo $description; ?></p>
                <?php endif; ?>

                <?php if(!empty($button)): ?>
                    <div class="cta">
                        <a class="arrow_button" href="<?php echo $button_link; ?>">
                            <?php echo $button_title; ?>
                            <span>→</span>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endif; ?>   
        </div>
    </div>
    <?php if($overlay): ?>
        <div class="gradient-overlay"></div>
    <?php endif; ?>
</section>
