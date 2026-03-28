<?php get_header(); ?>

<?php
    $context = get_the_ID();
    if ( ! is_front_page() && is_home() ) {
        $context = get_option('page_for_posts');
    }
    
    if ( get_field('title', $context) ) {
        get_template_part('components/page-banner');
    } else {
        get_template_part('components/simple-banner');
    }
?>

<?php if ( have_rows('page_builder') ): ?>
    <?php while ( have_rows('page_builder') ): the_row(); ?>
        <?php
            $layout = get_row_layout();
            if ( $layout ) {
                get_template_part( 'sections/' . $layout ); 
            }
        ?> 
    <?php endwhile; ?>
<?php endif; ?>

<?php get_footer(); ?>