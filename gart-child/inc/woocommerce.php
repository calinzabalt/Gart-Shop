<?php
/**
 * WooCommerce overrides – Gart Child
 * Author: Cozma Calin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Remove default WooCommerce wrappers
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

// Remove default WooCommerce breadcrumb (since it is rendered in the banner manually)
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Render ACF Page Builder sections on the Shop Page AFTER the loop
add_action( 'woocommerce_after_main_content', 'gart_child_woo_page_builder', 5 );
function gart_child_woo_page_builder() {
    if ( is_shop() ) {
        $shop_page_id = wc_get_page_id( 'shop' );
        if ( $shop_page_id && have_rows( 'page_builder', $shop_page_id ) ) {
            while ( have_rows( 'page_builder', $shop_page_id ) ) {
                the_row();
                $layout = get_row_layout();
                if ( $layout ) {
                    get_template_part( 'sections/' . $layout ); 
                }
            }
        }
    }
}

add_filter( 'woocommerce_get_image_size_thumbnail', 'gart_child_custom_woo_thumbnail_size' );
function gart_child_custom_woo_thumbnail_size( $size ) {
    return array(
        'width'  => 552,
        'height' => 1000,
        'crop'   => 1,
    );
}

// 1.5. Make single product gallery thumbnails load in high-res to prevent CSS pixelation
add_filter( 'woocommerce_gallery_thumbnail_size', 'gart_child_gallery_hires' );
function gart_child_gallery_hires() {
    return 'woocommerce_single';
}

remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

// --- Single Product Customizations ---

add_action( 'woocommerce_single_product_summary', 'woocommerce_breadcrumb', 4 );
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 31 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10 );
remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

add_action( 'woocommerce_single_product_summary', 'gart_child_product_description', 15 );
function gart_child_product_description() {
    global $post;
    if ( $post && $post->post_content ) {
        echo '<div class="woocommerce-product-details__description">';
        echo apply_filters( 'the_content', $post->post_content );
        echo '</div>';
    }
}

add_filter( 'woocommerce_product_related_products_heading', 'gart_child_related_products_heading' );
function gart_child_related_products_heading() {
    return gart_t('Produse Similare');
}

// 4. Preselect color and hide row
add_filter( 'woocommerce_dropdown_variation_attribute_options_args', 'gart_child_preselect_pa_culoare', 10, 1 );
function gart_child_preselect_pa_culoare( $args ) {
    if ( $args['attribute'] === 'pa_culoare' ) {
        if ( empty( $args['selected'] ) && ! empty( $args['options'] ) ) {
            $args['selected'] = $args['options'][0];
        }
    }
    return $args;
}

add_action( 'wp_head', 'gart_child_hide_pa_culoare_css' );
function gart_child_hide_pa_culoare_css() {
    if ( is_product() ) {
        echo '<style>.variations tr:has(select[name="attribute_pa_culoare"]), .variations .variation-row:has(select[name="attribute_pa_culoare"]) { display: none !important; }</style>';
    }
}

// 5. Custom HTML for pa_marime size boxes
add_filter( 'woocommerce_dropdown_variation_attribute_options_html', 'gart_child_pa_marime_html', 10, 2 );
function gart_child_pa_marime_html( $html, $args ) {
    if ( $args['attribute'] === 'pa_marime' ) {
        $options = $args['options'];
        
        global $product;
        $variations = $product->is_type( 'variable' ) ? $product->get_available_variations() : [];
        
        $custom_html = '<div class="size-boxes flex filter-marime">';
        foreach ( $options as $option ) {
            $val = esc_attr( $option );
            $label = $option;
            if ( taxonomy_exists( 'pa_marime' ) ) {
                $term = get_term_by( 'slug', $option, 'pa_marime' );
                if ( $term && ! is_wp_error( $term ) ) {
                    $label = $term->name;
                }
            }
            $label = esc_html( strtoupper( $label ) );
            
            // Check if this specific size is in stock
            $is_in_stock = false;
            foreach ( $variations as $variation ) {
                if ( isset( $variation['attributes']['attribute_pa_marime'] ) && $variation['attributes']['attribute_pa_marime'] === $val ) {
                    if ( $variation['is_in_stock'] ) {
                        $is_in_stock = true;
                        break;
                    }
                }
            }
            
            $class = 'size-box' . ( ! $is_in_stock ? ' out-of-stock' : '' );
            
            $custom_html .= '<label class="' . $class . '">';
            $custom_html .= '<input type="checkbox" name="custom_pa_marime" value="' . $val . '">';
            $custom_html .= '<span class="size-label">' . $label . '</span>';
            $custom_html .= '</label>';
        }
        $custom_html .= '</div>';
        
        $html = str_replace( '<select', '<select style="display:none;"', $html );
        return $custom_html . $html;
    }
    return $html;
}

// 6. JS to sync size boxes logic
add_action( 'wp_footer', 'gart_child_pa_marime_js' );
function gart_child_pa_marime_js() {
    if ( is_product() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var boxes = document.querySelectorAll('.size-box input[type="checkbox"][name="custom_pa_marime"]');
            var select = document.querySelector('select[name="attribute_pa_marime"]');
            
            if (boxes.length && select) {
                // Pre-check if already selected in select dropdown
                if (select.value) {
                    var activeBox = document.querySelector('.size-box input[value="' + select.value + '"]');
                    if(activeBox) activeBox.checked = true;
                }

                boxes.forEach(function(box) {
                    box.addEventListener('change', function() {
                        if (this.checked) {
                            // Uncheck all others
                            boxes.forEach(function(b) { if(b !== box) b.checked = false; });
                            select.value = this.value;
                            if (typeof jQuery !== 'undefined') {
                                jQuery(select).trigger('change');
                            }
                        } else {
                            select.value = '';
                            if (typeof jQuery !== 'undefined') {
                                jQuery(select).trigger('change');
                            }
                        }
                    });
                });

                // Clear constraints when woocommerce resets form
                if (typeof jQuery !== 'undefined') {
                    jQuery('.variations_form').on('reset_data', function() {
                        boxes.forEach(function(r) { r.checked = false; });
                    });
                }
            }
        });
        </script>
        <?php
    }
}

// 7. Add to cart text
add_filter( 'woocommerce_product_single_add_to_cart_text', 'gart_child_add_to_cart_text' );
add_filter( 'woocommerce_product_add_to_cart_text', 'gart_child_add_to_cart_text' );
function gart_child_add_to_cart_text() {
    return gart_t('ADAUGĂ ÎN COȘ');
}

// 8. Favorite (Wishlist) button logic
add_action( 'woocommerce_after_add_to_cart_form', 'gart_child_wishlist_btn' );
function gart_child_wishlist_btn() {
    global $product;
    if ( $product->is_type( 'variable' ) ) {
        // Hidden by default, toggled by JS when an out-of-stock variation is selected
        echo '<div class="gart-variable-wishlist" style="display:none;">';
        echo '<a href="#" class="button full_button favorite-btn">' . gart_t('ADAUGĂ LA FAVORITE') . '</a>';
        echo '</div>';
    } elseif ( ! $product->is_in_stock() ) {
        // Always shown if simple product is out of stock
        echo '<div class="gart-simple-wishlist">';
        echo '<a href="#" class="button full_button favorite-btn">' . gart_t('ADAUGĂ LA FAVORITE') . '</a>';
        echo '</div>';
    }
}

add_action( 'wp_footer', 'gart_child_wishlist_js' );
function gart_child_wishlist_js() {
    if ( is_product() ) {
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof jQuery !== 'undefined') {
                jQuery('.variations_form').on('show_variation', function(event, variation) {
                    if (variation.is_in_stock) {
                        jQuery('.gart-variable-wishlist').hide();
                        jQuery('.single_add_to_cart_button').prop('disabled', false);
                        jQuery('.quantity').show();
                    } else {
                        jQuery('.gart-variable-wishlist').show();
                        jQuery('.single_add_to_cart_button').prop('disabled', true);
                        jQuery('.quantity').hide();
                    }
                });
                jQuery('.variations_form').on('hide_variation reset_data', function() {
                    jQuery('.gart-variable-wishlist').hide();
                    jQuery('.single_add_to_cart_button').prop('disabled', false);
                    jQuery('.quantity').show();
                });
            }
        });
        </script>
        <?php
    }
}