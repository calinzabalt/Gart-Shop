<section class="blog_posts">
    <div class="container smaller">
        <?php
        $paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );
        
        $args = array(
            'post_type'      => 'post',
            'post_status'    => 'publish',
            'posts_per_page' => 9,
            'paged'          => 1,
        );
        
        $blog_query = new WP_Query( $args );

        if ( $blog_query->have_posts() ) : ?>
            <div class="posts_grid">
                <?php while ( $blog_query->have_posts() ) : $blog_query->the_post(); ?>
                    <?php get_template_part( 'components/blog-post' ); ?>
                <?php endwhile; ?>
            </div>

            <?php if ( $blog_query->found_posts > 9 ) : ?>
                <div class="gart-load-more-container">
                    <button class="btn gart-load-more" data-page="2"><?php echo gart_t('Încarcă mai multe'); ?> <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 transition-transform"><path d="m6 9 6 6 6-6"></path></svg></button>
                </div>
            <?php endif; ?>
            
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No posts found.', 'gart-child' ); ?></p>
        <?php endif; ?>
    </div>
</section>