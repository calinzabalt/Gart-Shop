<?php get_header(); ?>

<?php while ( have_posts() ) : the_post(); 
    $word_count = str_word_count( strip_tags( get_the_content() ) );
    $reading_time = ceil($word_count / 200);
    if ($reading_time < 1) {
        $reading_time = 1;
    }
    $reading_text = $reading_time == 1 ? 'minut' : 'minute';
    $ro_date = gart_get_romanian_date();
    $social_icons = get_field('social_icons', 'option');
?>

<div class="single_article_container">
    <div class="container">
        <div class="article_header text-center">
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
                <h1><?php the_title(); ?></h1>
            </div>
            
            <div class="article_meta">
                <span class="post_date"><?php echo $ro_date; ?></span>
                <span class="meta_separator">|</span>
                <span class="read_time">Timp de citire: <?php echo $reading_time . ' ' . $reading_text; ?></span>
            </div>
        </div>
    </div>

    <div class="thumbnail">
        <?php if ( has_post_thumbnail() ) : ?>
            <?php the_post_thumbnail( 'full' ); ?>
        <?php endif; ?>
    </div>
    
    <div class="container">
        <div class="article_content">
            <?php the_content(); ?>
        </div>

        <div class="article_share">
            <p>Distribuie acest articol:</p>
            
            <div class="social_media">
                <div class="social_icons">
                    <?php if($social_icons):?>
                        <?php foreach($social_icons as $icon):?>
                            <a href="<?php echo $icon['link'];?>" target="_blank">
                                <img src="<?php echo $icon['icon'];?>" alt="Social Icon">
                            </a>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
$title = "Articole Similare";
$categories = wp_get_post_categories(get_the_ID());
$similar_args = array(
    'post_type'      => 'post',
    'post_status'    => 'publish',
    'posts_per_page' => 3,
    'category__in'   => $categories,
    'post__not_in'   => array(get_the_ID()),
);
$similar_query = new WP_Query( $similar_args );

if ( $similar_query->have_posts() ) : ?>
    <section class="blog_posts similar_posts">
        <div class="container smaller">
            <h2 class="section_title text-align-center"><?php echo $title;?></h2>
            <div class="posts_grid">
                <?php while ( $similar_query->have_posts() ) : $similar_query->the_post(); ?>
                    <?php get_template_part( 'components/blog-post' ); ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php wp_reset_postdata(); ?>
<?php endif; ?>

<?php endwhile; ?>

<?php get_footer(); ?>
