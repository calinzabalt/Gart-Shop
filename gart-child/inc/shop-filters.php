<?php
/**
 * Shop Filters Template
 */
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<div class="shop-filter-header flex">
    <h3 class="filter-title">
        <?php echo gart_t('Filtre'); ?>
        <svg class="filter-dropdown-icon" width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1 1L7 7L13 1" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </h3>
    <a href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>" class="reset-filters"><?php echo gart_t('Resetează'); ?></a>
</div>

<?php 
// 1. Categories
$categories = get_terms( array(
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'exclude'    => get_option( 'default_product_cat', 0 )
) );

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ): 
?>
    <div class="filter-widget filter-categories">
        <h4 class="filter-widget-title"><?php echo gart_t('CATEGORIE'); ?></h4>
        <ul class="filter-list">
            <?php foreach ( $categories as $category ): 
                $lang = function_exists('pll_current_language') ? pll_current_language() : '';
                $locale = get_locale();
                $is_en = ($lang === 'en' || strpos($lang, 'en') === 0 || strpos($locale, 'en') === 0);

                $exclude_slugs = array('licitatii');
                
                if ( $is_en ) {
                    $exclude_slugs[] = 'licitatii-en';
                    $exclude_slugs[] = 'uncategorized-en';
                    $exclude_slugs[] = 'uncategorized';
                } else {
                    $exclude_slugs[] = 'licitatii-ro';
                    $exclude_slugs[] = 'uncategorized';
                }

                if ( in_array( $category->slug, $exclude_slugs ) ) continue;
            ?>
                <li>
                    <label>
                        <input type="checkbox" name="cat" value="<?php echo esc_attr( $category->slug ); ?>">
                        <?php echo esc_html( $category->name ); ?>
                    </label>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<?php
// 2. Size Attribute (pa_marime)
$sizes = get_terms( array(
    'taxonomy'   => 'pa_marime',
    'hide_empty' => false,
) );

if ( ! empty( $sizes ) && ! is_wp_error( $sizes ) ):
?>
    <div class="filter-widget filter-marime">
        <h4 class="filter-widget-title"><?php echo gart_t('MĂRIME'); ?></h4>
        <div class="size-boxes flex">
            <?php foreach ( $sizes as $term ): ?>
                <label class="size-box">
                    <input type="checkbox" name="pa_marime" value="<?php echo esc_attr( $term->slug ); ?>">
                    <span class="size-label"><?php echo esc_html( $term->name ); ?></span>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<?php
// 3. Color Attribute (pa_culoare)
$colors = get_terms( array(
    'taxonomy'   => 'pa_culoare',
    'hide_empty' => false,
) );

if ( ! empty( $colors ) && ! is_wp_error( $colors ) ):
?>
    <div class="filter-widget filter-culoare">
        <h4 class="filter-widget-title"><?php echo gart_t('CULOARE'); ?></h4>
        <div class="color-boxes flex">
            <?php foreach ( $colors as $term ): ?>
                <label class="color-box <?php echo esc_attr( $term->slug ); ?>">
                    <input type="checkbox" name="pa_culoare" value="<?php echo esc_attr( $term->slug ); ?>">
                </label>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterHeader = document.querySelector('.shop-filter-header .filter-title');
    if (filterHeader) {
        filterHeader.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const filterContainer = document.querySelector('.left_filters');
                if(filterContainer) {
                    filterContainer.classList.toggle('active');
                }
            }
        });
    }
});
</script>
