<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <a href="<?php the_permalink(); ?>" class="post_global_link">
        <div class="thumbnail">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'large' ); ?>
            <?php endif; ?>
        </div>
        <div class="post_category">
            <?php 
                $categories = get_the_category();
                if ( ! empty( $categories ) ) {
                    $cat_names = wp_list_pluck( $categories, 'name' );
                    echo esc_html( implode( ', ', $cat_names ) );
                }
            ?>
        </div>
        <div class="post_title">
            <h3><?php the_title(); ?></h3>
        </div>
        <div class="post_description">
            <?php 
                $excerpt = wp_strip_all_tags( get_the_excerpt() );
                echo wp_trim_words( $excerpt, 15, '...' );
            ?>
        </div>
        <div class="post_date">
            <?php echo gart_get_romanian_date(); ?>
        </div>
    </a>
</article>