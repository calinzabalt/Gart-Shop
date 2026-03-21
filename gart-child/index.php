<?php get_header(); ?>

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