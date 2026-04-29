<?php
/**
 * Gart Child – Functions
 * Author: Cozma Calin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Exclude auctions from main shop loop
add_action( 'woocommerce_product_query', 'gart_exclude_auctions_from_shop' );
function gart_exclude_auctions_from_shop( $q ) {
    $tax_query = (array) $q->get( 'tax_query' );

    $tax_query[] = array(
        'taxonomy' => 'product_type',
        'field'    => 'slug',
        'terms'    => array( 'auction' ),
        'operator' => 'NOT IN',
    );
    
    $tax_query[] = array(
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => array( 'licitatii' ),
        'operator' => 'NOT IN',
    );

    $q->set( 'tax_query', $tax_query );
}

remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Disable comments completely
add_action('init', function () {
    // Remove comment support from all post types
    $post_types = get_post_types();
    foreach ($post_types as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }

});
// Close comments on the frontend
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments page from admin
add_action('admin_menu', function () {
    remove_menu_page('edit-comments.php');
});

// Redirect comments page if accessed directly
add_action('admin_init', function () {
    global $pagenow;

    if ($pagenow === 'edit-comments.php') {
        wp_redirect(admin_url());
        exit;
    }
});
// Remove comments from admin bar
add_action('admin_bar_menu', function ($wp_admin_bar) {
    $wp_admin_bar->remove_node('comments');
}, 999);

// Load child styles
add_action( 'wp_enqueue_scripts', 'gart_child_enqueue_styles', 20 );
function gart_child_enqueue_styles() {
    wp_enqueue_style( 'gart-child-style', get_stylesheet_uri(), array('gart-parent-style'), wp_get_theme()->get('Version') );
}

// Enqueue main.js + localize AJAX
add_action( 'wp_enqueue_scripts', 'gart_child_enqueue_scripts' );
function gart_child_enqueue_scripts() {
    wp_enqueue_script( 'jquery' );

    wp_enqueue_script(
        'gart-main',
        get_stylesheet_directory_uri() . '/assets/js/main.js',
        array('jquery'),
        '1.0.1',
        true
    );

    wp_localize_script( 'gart-main', 'gart_ajax', array(
        'url'   => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('gart_nonce'),
        'lang'  => function_exists('pll_current_language') ? pll_current_language() : 'ro',
        'strings' => array(
            'auth' => gart_t('Autentificare'),
            'register' => gart_t('Înregistrare'),
            'lost_pass' => gart_t('Recuperare Parolă'),
            'user_or_email' => gart_t('Nume utilizator sau adresă email *'),
            'password' => gart_t('Parolă *'),
            'remember_me' => gart_t('Ține-mă minte'),
            'create_account' => gart_t('Creează cont'),
            'forgot_pass_link' => gart_t('Ți-ai pierdut parola?'),
            'username' => gart_t('Nume utilizator *'),
            'email' => gart_t('Email *'),
            'already_account' => gart_t('Ai deja un cont? Autentificare'),
            'back_to_login' => gart_t('Înapoi la Autentificare'),
            'wait' => gart_t('Vă rugăm așteptați...'),
            'error' => gart_t('A apărut o eroare.'),
            'request_error' => gart_t('O eroare a apărut la procesarea solicitării.'),
            'loading' => gart_t('Se încarcă...'),
            'load_more' => gart_t('Încarcă mai multe'),
            'no_products' => gart_t('Niciun produs găsit.'),
            'reset_pass' => gart_t('Resetare Parolă'),
            'success' => gart_t('Succes!'),
        )
    ) );

    // WooCommerce Blocks – Romanian JS translations (must load before Blocks render)
    $lang = function_exists('pll_current_language') ? pll_current_language() : '';
    $locale = get_locale();
    $is_en = ($lang === 'en' || strpos($lang, 'en') === 0 || strpos($locale, 'en') === 0);

    if ( ! $is_en ) {
        wp_enqueue_script(
            'gart-wc-blocks-ro',
            get_stylesheet_directory_uri() . '/assets/js/wc-blocks-ro.js',
            array( 'wp-hooks', 'wp-i18n' ),
            '1.1.1',
            false  // load in <head> so it runs before React/Blocks hydration
        );
    } else {
        // Force English for key blocks strings in JS
        wp_add_inline_script('wp-hooks', "
            (function() {
                if (typeof wp === 'undefined' || !wp.hooks) return;
                const fixEn = (t, text) => {
                    if (text === 'Cart totals' || text === 'Cart Totals') return 'Cart Totals';
                    if (text === 'Proceed to Checkout') return 'Proceed to Checkout';
                    return t;
                };
                wp.hooks.addFilter('i18n.gettext_woocommerce', 'gart/en-fix', fixEn);
                wp.hooks.addFilter('i18n.gettext_woo-gutenberg-products-block', 'gart/en-fix-blocks', fixEn);
            })();
        ", 'before');
    }
}

function gart_enqueue_google_fonts() {
    $fonts_url = 'https://fonts.googleapis.com/css2?' .
                 'family=Montserrat:wght@400;500;600;700' .
                 '&family=Playfair+Display:wght@400;500;600;700;800;900' .
                 '&display=swap';
                 
    wp_enqueue_style(
        'google-fonts',
        $fonts_url,
        array(),              
        null
    );

    add_action('wp_head', function() {
        echo '<link rel="preload" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500&family=Playfair+Display:wght@700&display=swap" as="style" crossorigin="anonymous">';
    }, 1);
}
add_action('wp_enqueue_scripts', 'gart_enqueue_google_fonts', 12);

// Add WooCommerce support
add_action( 'after_setup_theme', function() {
    add_theme_support( 'woocommerce' );
}, 20 );

add_theme_support('custom-logo');

// Load WooCommerce overrides
if ( file_exists( get_stylesheet_directory() . '/inc/woocommerce.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/woocommerce.php';
}

// Load Polylang translations
if ( file_exists( get_stylesheet_directory() . '/inc/translations.php' ) ) {
    require_once get_stylesheet_directory() . '/inc/translations.php';
}

/**
 * Polylang WooCommerce Synchronization
 * Ensures WooCommerce uses the correct page ID for each language
 */
if ( function_exists( 'pll_get_post' ) ) {
    $woo_pages = array( 'cart', 'checkout', 'myaccount', 'shop' );
    foreach ( $woo_pages as $page ) {
        add_filter( 'option_woocommerce_' . $page . '_page_id', 'gart_pll_woo_page_id' );
        // Also filter the direct WooCommerce page ID functions for better compatibility
        add_filter( 'woocommerce_get_' . $page . '_page_id', 'gart_pll_woo_page_id' );
    }
}

function gart_pll_woo_page_id( $id ) {
    if ( ! $id ) return $id;
    if ( function_exists( 'pll_get_post' ) ) {
        $translated_id = pll_get_post( $id );
        if ( $translated_id ) {
            return $translated_id;
        }
    }
    return $id;
}

// Ensure the URLs themselves are filtered as a last resort
add_filter( 'woocommerce_get_cart_url', 'gart_fix_pll_woo_url', 99 );
add_filter( 'woocommerce_get_checkout_url', 'gart_fix_pll_woo_url', 99 );

function gart_fix_pll_woo_url( $url ) {
    if ( function_exists( 'pll_get_post' ) ) {
        // Find which page this is for
        $option_name = current_filter() === 'woocommerce_get_cart_url' ? 'woocommerce_cart_page_id' : 'woocommerce_checkout_page_id';
        $base_id = get_option( $option_name );
        $translated_id = pll_get_post( $base_id );
        if ( $translated_id ) {
            return get_permalink( $translated_id );
        }
    }
    return $url;
}

register_nav_menus([
    'menu_left'  => 'Menu Left',
    'menu_right' => 'Menu Right',
]);

// Inject modal HTML
add_action( 'wp_footer', 'gart_inject_login_modal' );
function gart_inject_login_modal() {
    ?>
    <div id="login-register-modal">
        <div class="modal-content">
            <div id="modal-forms"></div>
        </div>
    </div>
    <?php
}

// Inject Sizes Guide modal HTML
add_action( 'wp_footer', 'gart_inject_sizes_modal' );
function gart_inject_sizes_modal() {
    ?>
    <div id="sizes-modal" class="custom-modal">
        <div class="modal-content">
            <div class="modal-close close-modal-btn">
                <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" viewBox="0 0 384 512"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
            </div>
            <div id="sizes-modal-content"></div>
        </div>
    </div>
    <?php
}

// ────── Secure AJAX Login ──────
add_action( 'wp_ajax_nopriv_gart_login', 'gart_ajax_login' );
add_action( 'wp_ajax_gart_login', 'gart_ajax_login' );
function gart_ajax_login() {
    check_ajax_referer( 'gart_nonce', 'security' );

    $username = isset($_POST['username']) ? sanitize_user($_POST['username'], true) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;

    if ( empty($username) || empty($password) ) {
        wp_send_json_error( array('message' => gart_t('Toate câmpurile sunt obligatorii.')) );
    }

    $user = wp_signon( array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    ), is_ssl() );

    if ( is_wp_error($user) ) {
        wp_send_json_error( array('message' => gart_t('Autentificare eșuată. Verificați datele și încercați din nou.')) );
    }

    wp_send_json_success( array('message' => gart_t('Autentificare cu succes!')) );
}

// ────── Secure AJAX Lost Password ──────
add_action( 'wp_ajax_nopriv_gart_lost_password', 'gart_ajax_lost_password' );
add_action( 'wp_ajax_gart_lost_password', 'gart_ajax_lost_password' );
function gart_ajax_lost_password() {
    check_ajax_referer( 'gart_nonce', 'security' );

    $user_login = isset($_POST['user_login']) ? sanitize_user($_POST['user_login']) : '';

    if ( empty($user_login) ) {
        wp_send_json_error( array('message' => gart_t('Vă rugăm să introduceți un nume de utilizator sau o adresă de email.')) );
    }

    $user_data = get_user_by( 'email', $user_login );
    if ( ! $user_data ) {
        $user_data = get_user_by( 'login', $user_login );
    }

    if ( ! $user_data ) {
        wp_send_json_error( array('message' => gart_t('Nu există niciun cont cu acest nume de utilizator sau adresă de email.')) );
    }

    $result = retrieve_password( $user_login );

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array('message' => gart_t('A apărut o eroare la trimiterea emailului de resetare.')) );
    }

    wp_send_json_success( array('message' => gart_t('Un email de resetare a parolei a fost trimis.')) );
}

// ────── Secure AJAX Register ──────
add_action( 'wp_ajax_nopriv_gart_register', 'gart_ajax_register' );
add_action( 'wp_ajax_gart_register', 'gart_ajax_register' );
function gart_ajax_register() {
    check_ajax_referer( 'gart_nonce', 'security' );

    $username = isset($_POST['username']) ? sanitize_user($_POST['username'], true) : '';
    $email    = isset($_POST['email'])    ? sanitize_email($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ( empty($username) || empty($email) || empty($password) ) {
        wp_send_json_error( array('message' => gart_t('Toate câmpurile sunt obligatorii.')) );
    }

    if ( !is_email($email) ) {
        wp_send_json_error( array('message' => gart_t('Adresă de email invalidă.')) );
    }

    if ( username_exists($username) || email_exists($email) ) {
        wp_send_json_error( array('message' => gart_t('Numele de utilizator sau emailul este deja folosit.')) );
    }

    $user_id = wc_create_new_customer( $email, $username, $password );

    if ( is_wp_error($user_id) ) {
        wp_send_json_error( array('message' => $user_id->get_error_message()) );
    }

    wp_signon( array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => true
    ), is_ssl() );

    wp_send_json_success( array('message' => gart_t('Înregistrare cu succes!')) );
}

add_action('acf/init', function() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'      => 'Theme Settings',
            'menu_title'      => 'Theme Settings',
            'menu_slug'       => 'theme-settings',
            'capability'      => 'edit_posts',
            'redirect'        => false,
            'position'        => 5,
            'icon_url'        => 'dashicons-admin-customizer',
            'updated_message' => __('Theme settings updated.', 'your-text-domain'),
        ]);

        // Add a sub-page for each non-default Polylang language
        if ( function_exists('pll_languages_list') && function_exists('pll_default_language') ) {
            foreach ( pll_languages_list() as $lang ) {
                if ( $lang === pll_default_language() ) continue;
                acf_add_options_sub_page([
                    'page_title'  => 'Theme Settings (' . strtoupper($lang) . ')',
                    'menu_title'  => strtoupper($lang),
                    'parent_slug' => 'theme-settings',
                    'post_id'     => 'options_' . $lang,
                ]);
            }
        }
    }
});

/**
 * Language-aware ACF option getter.
 * Reads from the translated options page first; falls back to the default.
 */
function gart_get_option( $field ) {
    if ( function_exists('pll_current_language') && function_exists('pll_default_language') ) {
        $lang = pll_current_language();
        if ( $lang && $lang !== pll_default_language() ) {
            $val = get_field( $field, 'options_' . $lang );
            if ( $val ) return $val;
        }
    }
    return get_field( $field, 'option' );
}

/**
 * Direct translation helper.
 * Usage: gart_t('Filtre') outputs 'Filters' on EN, 'Filtre' on RO.
 */
function gart_t( $text ) {
    $lang = function_exists('pll_current_language') ? pll_current_language() : '';
    $locale = get_locale();
    
    // Support 'en', 'en_US', 'en_GB', etc. from both Polylang and WP Locale
    $is_en = ($lang === 'en' || strpos($lang, 'en') === 0 || strpos($locale, 'en') === 0);
    
    if ( ! $is_en ) {
        return $text;
    }

    static $en = null;
    if ( $en === null ) {
        $en = array(
            // ── Theme UI ──
            'Toate drepturile rezervate.'                           => 'All rights reserved.',
            'Încarcă mai multe'                                     => 'Load more',
            'Filtre'                                                => 'Filters',
            'Resetează'                                             => 'Reset',
            'CATEGORIE'                                             => 'CATEGORY',
            'MĂRIME'                                                => 'SIZE',
            'CULOARE'                                               => 'COLOR',
            'Înapoi'                                                => 'Back',
            'CANTITATE'                                             => 'QUANTITY',
            'Mărime'                                                => 'Size',

            // ── WooCommerce Custom ──
            'ADAUGĂ ÎN COȘ'                                        => 'ADD TO CART',
            'ADAUGĂ LA FAVORITE'                                    => 'ADD TO WISHLIST',
            'Vezi coșul'                                            => 'View cart',
            'Produse Similare'                                      => 'Similar Products',
            'Acasă'                                                 => 'Home',
            'Afisare produsul'                                      => 'Showing the product',
            'Afisare toate cele %d produse'                         => 'Showing all %d products',
            'Afisare %1$d–%2$d din %3$d produse'                   => 'Showing %1$d–%2$d of %3$d products',
            'Se afișează %d produse'                               => 'Showing %d products',
            'Se afisează %d produse'                               => 'Showing %d products',
            'Se afiseaza %d produse'                               => 'Showing %d products',
            'Se afişează %d produse'                               => 'Showing %d products',
            '%s a fost adăugat în coșul tău.'                       => '%s has been added to your cart.',

            // ── Account & AJAX ──
            'Toate câmpurile sunt obligatorii.'                     => 'All fields are required.',
            'Adresă de email invalidă.'                             => 'Invalid email address.',
            'Numele de utilizator sau emailul este deja folosit.'   => 'Username or email already in use.',
            'Înregistrare cu succes!'                               => 'Registration successful!',
            'Autentificare cu succes!'                               => 'Login successful!',
            'Autentificare eșuată. Verificați datele și încercați din nou.' => 'Login failed. Check your credentials and try again.',
            'Vă rugăm să introduceți un nume de utilizator sau o adresă de email.' => 'Please enter a username or email address.',
            'Nu există niciun cont cu acest nume de utilizator sau adresă de email.' => 'No account found with that username or email.',
            'A apărut o eroare la trimiterea emailului de resetare.' => 'An error occurred while sending the reset email.',
            'Un email de resetare a parolei a fost trimis.'         => 'A password reset email has been sent.',

            // ── JS Localized ──
            'Autentificare'                                         => 'Login',
            'Înregistrare'                                          => 'Register',
            'Recuperare Parolă'                                     => 'Password Recovery',
            'Nume utilizator sau adresă email *'                    => 'Username or email *',
            'Parolă *'                                              => 'Password *',
            'Ține-mă minte'                                         => 'Remember me',
            'Creează cont'                                          => 'Create account',
            'Ți-ai pierdut parola?'                                 => 'Lost your password?',
            'Nume utilizator *'                                     => 'Username *',
            'Email *'                                               => 'Email *',
            'Ai deja un cont? Autentificare'                        => 'Already have an account? Login',
            'Înapoi la Autentificare'                               => 'Back to Login',
            'Vă rugăm așteptați...'                                 => 'Please wait...',
            'A apărut o eroare.'                                    => 'An error occurred.',
            'O eroare a apărut la procesarea solicitării.'           => 'An error occurred while processing the request.',
            'Se încarcă...'                                         => 'Loading...',
            'Niciun produs găsit.'                                  => 'No products found.',
            'Resetare Parolă'                                       => 'Reset Password',
            'Succes!'                                               => 'Success!',

            // ── Wishlist ──
            'Nu ai adaugat niciun produs la favorite inca.'         => 'You haven\'t added any products to your wishlist yet.',
            'Produs'                                                => 'Product',
            'Pret'                                                  => 'Price',
            'Stoc'                                                  => 'Stock',
            'In Stoc'                                               => 'In Stock',
            'Stoc Epuizat'                                          => 'Out of Stock',
            'Sterge articol'                                        => 'Remove item',
            'ELIMINA DIN FAVORITE'                                  => 'REMOVE FROM WISHLIST',

            // ── Auction ──
            'LICITAȚIE ACTIVĂ'                                      => 'ACTIVE AUCTION',
            'LICITATIE ACTIVĂ'                                      => 'ACTIVE AUCTION',
            'LICITATIE ACTIVA'                                      => 'ACTIVE AUCTION',
            'Licitație încheiată'                                   => 'Auction ended',
            'Licitatie încheiată'                                   => 'Auction ended',
            'Licitatie incheiata'                                   => 'Auction ended',
            'Se încheie în:'                                        => 'Ends in:',
            'Se incheie in:'                                        => 'Ends in:',
            'Bid curent:'                                           => 'Current bid:',
            'Plasează Bid'                                          => 'Place Bid',
            'Plaseaza Bid'                                          => 'Place Bid',
            'Minimum bid: %s'                                       => 'Minimum bid: %s',
            'Câștigător: <strong>%s</strong>'                       => 'Winner: <strong>%s</strong>',
            'Castigator: <strong>%s</strong>'                       => 'Winner: <strong>%s</strong>',
            'Felicitări! Ai câștigat această licitație.'            => 'Congratulations! You won this auction.',
            'Adaugă în coș'                                         => 'Add to cart',
            'Nicio ofertă validă.'                                  => 'No valid bids.',
            'Istoric Licitație'                                     => 'Auction History',
            'Niciun bid momentan.'                                  => 'No bids yet.',
            'Trebuie să fii autentificat pentru a licita.'          => 'You must be logged in to bid.',
            'Bid nevalid.'                                          => 'Invalid bid.',
            'Licitația s-a încheiat deja.'                          => 'The auction has already ended.',
            'Bidul trebuie să fie cel puțin %s.'                    => 'The bid must be at least %s.',
            'Bid plasat cu succes!'                                 => 'Bid placed successfully!',
            'Câștigă Licitația'                                     => 'Win the Auction',
            'Vezi detalii produs'                                   => 'View product details',
            'în urmă'                                               => 'ago',
            'Ghid Mărimi'                                           => 'Size Guide',
            'z'                                                     => 'd',
            'Se trimite...'                                         => 'Sending...',
            'Vă rugăm introduceți o sumă validă.'                   => 'Please enter a valid amount.',
            'Eroare la plasarea bidului.'                            => 'Error placing bid.',
            'Eroare server. Încercați din nou.'                      => 'Server error. Please try again.',
            'Minimum bid:'                                          => 'Minimum bid:',
            'Timp de citire:'                                       => 'Reading time:',
            'minut'                                                 => 'minute',
            'minute'                                                => 'minutes',
            'Distribuie acest articol:'                             => 'Share this article:',
            'Articole Similare'                                     => 'Similar Articles',
        );
    }

    return isset( $en[ $text ] ) ? $en[ $text ] : $text;
}

/**
 * Translate WooCommerce attribute labels on the frontend
 * e.g. "Mărime" → "Size" when viewing the English version
 */
add_filter( 'woocommerce_attribute_label', 'gart_translate_attribute_label', 10, 3 );
function gart_translate_attribute_label( $label, $name, $product ) {
    if ( function_exists('pll_current_language') && pll_current_language() === 'en' ) {
        $map = array(
            'Mărime'  => 'Size',
            'Culoare' => 'Color',
            'Marime'  => 'Size',
        );
        if ( isset( $map[ $label ] ) ) {
            return $map[ $label ];
        }
    }
    return $label;
}

/**
 * Make the Wishlist language-agnostic: always store the default-language product ID.
 * This ensures items added on /en/ appear in the RO wishlist and vice-versa,
 * the same way WooCommerce cart already works.
 */
add_filter( 'gart_wishlist_product_id', 'gart_wishlist_normalize_product_id' );
function gart_wishlist_normalize_product_id( $product_id ) {
    if ( function_exists('pll_get_post') ) {
        $default_id = pll_get_post( $product_id, pll_default_language() );
        if ( $default_id ) {
            return $default_id;
        }
    }
    return $product_id;
}

/**
 * Get the current wishlist count
 */
function gart_get_wishlist_count() {
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $wishlist = get_user_meta( $user_id, '_gart_wishlist_items', true );
    } else {
        $wishlist = isset( $_COOKIE['gart_wishlist_items'] ) ? json_decode( stripslashes( $_COOKIE['gart_wishlist_items'] ), true ) : array();
    }
    
    if ( ! is_array( $wishlist ) ) {
        return 0;
    }
    
    return count( $wishlist );
}

add_filter('gettext', 'gart_translate_woocommerce_strings', 999, 3);
add_filter( 'wc_add_to_cart_message_html', 'gart_ro_add_to_cart_message', 10, 3 );
function gart_ro_add_to_cart_message( $message, $products, $show_qty ) {
    $titles = array();
    foreach ( $products as $product_id => $qty ) {
        $title = get_the_title( $product_id );
        $titles[] = ( $show_qty && $qty > 1 )
            ? sprintf( '&ldquo;%s&rdquo; &times; %d', $title, $qty )
            : sprintf( '&ldquo;%s&rdquo;', $title );
    }
    $products_list = implode( ', ', $titles );
    $cart_url      = wc_get_cart_url();

    $vezi_cosul = gart_t('Vezi coșul');
    $msg = gart_t('%s a fost adăugat în coșul tău.');

    return sprintf(
        $msg . ' <a href="%s" class="button wc-forward">%s</a>',
        $products_list,
        esc_url( $cart_url ),
        $vezi_cosul
    );
}

add_filter( 'ngettext', 'gart_ro_ngettext_cart', 10, 5 );
function gart_ro_ngettext_cart( $translation, $single, $plural, $number, $domain ) {
    if ( 'woocommerce' !== $domain ) {
        return $translation;
    }

    $ngettext_map = [
        '%s has been added to your cart.'  => [ 1 => '%s a fost adăugat în coșul tău.',  'n' => '%s au fost adăugate în coșul tău.' ],
        '%s item'                          => [ 1 => '%s produs',                          'n' => '%s produse' ],
        '%s product'                       => [ 1 => '%s produs',                          'n' => '%s produse' ],
        '%s review'                        => [ 1 => '%s recenzie',                        'n' => '%s recenzii' ],
        '%s order'                         => [ 1 => '%s comandă',                         'n' => '%s comenzi' ],
    ];

    if ( isset( $ngettext_map[ $single ] ) ) {
        return $number > 1 ? $ngettext_map[ $single ]['n'] : $ngettext_map[ $single ][1];
    }

    return $translation;
}

add_filter('gettext', 'gart_translate_woocommerce_strings', 999, 3);
add_filter('gettext_with_context', 'gart_translate_woocommerce_strings', 999, 4);
function gart_translate_woocommerce_strings($translated_text, $text, $domain = 'woocommerce') {
    if (is_admin() && !wp_doing_ajax()) {
        return $translated_text;
    }

    $lang = function_exists('pll_current_language') ? pll_current_language() : '';
    $locale = get_locale();
    $is_en = ($lang === 'en' || strpos($lang, 'en') === 0 || strpos($locale, 'en') === 0);

    // If language is English, return the original English string ($text)
    // and skip the Romanian map.
    if ( $is_en ) {
        $low_text = strtolower($text);
        $low_translated = strtolower($translated_text);
        
        // Extra safety for the persistent "Total coș" issue
        if ( $low_text === 'total coș' || $low_translated === 'total coș' || 
             $low_text === 'total coş' || $low_translated === 'total coş' ||
             $low_text === 'cart totals' ) {
            return 'Cart Totals';
        }

        $en_orderby_map = [
            'Default sorting'            => 'Default',
            'Sort by popularity'         => 'Popularity',
            'Sort by average rating'     => 'Average rating',
            'Sort by latest'             => 'Latest',
            'Sort by price: low to high' => 'Price: low to high',
            'Sort by price: high to low' => 'Price: high to low',
        ];

        if ( isset( $en_orderby_map[ $text ] ) ) {
            return $en_orderby_map[ $text ];
        }

        return $text;
    }

    $map = [
        // ── Shop sorting ──────────────────────────────────────
        'Default sorting'                        => 'Implicită',
        'Sort by popularity'                     => 'Popularitate',
        'Sort by average rating'                 => 'Evaluare medie',
        'Sort by latest'                         => 'Cele mai recente',
        'Sort by price: low to high'             => 'Preț: crescător',
        'Sort by price: high to low'             => 'Preț: descrescător',

        // ── Cart notices ──────────────────────────────────────
        'View cart'                              => 'Vezi coșul',
        'Cart updated.'                          => 'Coșul a fost actualizat.',
        'Your cart is currently empty.'          => 'Coșul tău este gol.',
        'Return to shop'                         => 'Înapoi la magazin',
        'Continue shopping'                      => 'Continuă cumpărăturile',

        // ── Cart table headers ────────────────────────────────
        'Product'                                => 'Produs',
        'Price'                                  => 'Preț',
        'Quantity'                               => 'Cantitate',
        'Subtotal'                               => 'Subtotal',
        'Remove this item'                       => 'Șterge',

        // ── Cart totals block ─────────────────────────────────
        'Cart totals'                            => 'Total coș',
        'Shipping'                               => 'Livrare',
        'Total'                                  => 'Total',
        'Apply coupon'                           => 'Aplică cuponul',
        'Update cart'                            => 'Actualizează coșul',
        'Proceed to checkout'                    => 'Finalizează comanda',
        'Coupon:'                                => 'Cupon:',
        'Coupon code'                            => 'Cod cupon',
        'Enter code'                             => 'Introdu codul',
        'Calculate shipping'                     => 'Calculează livrarea',
        'Flat rate'                              => 'Tarif fix',
        'Free shipping'                          => 'Livrare gratuită',
        'No shipping options were found.'        => 'Nu există opțiuni de livrare disponibile.',
        'Shipping to %s.'                        => 'Livrare către %s.',

        // ── Checkout fields ───────────────────────────────────
        'Billing details'                        => 'Date de facturare',
        'Billing address'                        => 'Adresă de facturare',
        'Shipping address'                       => 'Adresă de livrare',
        'Ship to a different address?'           => 'Livrare la o altă adresă?',
        'Order notes'                            => 'Note comandă',
        'Notes about your order, e.g. special notes for delivery.' => 'Note despre comandă, ex. instrucțiuni speciale pentru livrare.',
        'Your order'                             => 'Comanda ta',
        'Place order'                            => 'Plasează comanda',
        'Have a coupon?'                         => 'Ai un cod de cupon?',
        'Click here to enter your code'         => 'Click aici pentru a introduce codul',
        'I have read and agree to the website %s' => 'Am citit și sunt de acord cu %s ale site-ului',
        'terms and conditions'                   => 'termenii și condițiile',
        'Privacy policy'                         => 'Politică de confidențialitate',

        // ── Checkout: personal fields ─────────────────────────
        'First name'                             => 'Prenume',
        'Last name'                              => 'Nume',
        'Company name (optional)'                => 'Companie (opțional)',
        'Country / Region'                       => 'Țară / Regiune',
        'Street address'                         => 'Adresă',
        'Apartment, suite, unit, etc. (optional)' => 'Bloc, scară, apartament (opțional)',
        'Town / City'                            => 'Oraș',
        'State / County'                         => 'Județ',
        'Postcode / ZIP'                         => 'Cod poștal',
        'Phone'                                  => 'Telefon',
        'Email address'                          => 'Adresă de email',
        'Email'                                  => 'Email',
        'Order notes (optional)'                 => 'Note pentru comandă (opțional)',

        // ── Checkout: order summary ───────────────────────────
        'Order summary'                          => 'Rezumat comandă',
        'Product'                                => 'Produs',
        'Subtotal'                               => 'Subtotal',
        'Total'                                  => 'Total',
        'Shipping'                               => 'Livrare',
        'Payment'                                => 'Plată',
        'Payment method'                         => 'Metodă de plată',
        'Direct bank transfer'                   => 'Transfer bancar',
        'Cash on delivery'                       => 'Ramburs la livrare',
        'Your order'                             => 'Comanda ta',

        // ── My Account navigation ─────────────────────────────
        'My account'                             => 'Contul meu',
        'Dashboard'                              => 'Panou de control',
        'Orders'                                 => 'Comenzi',
        'Downloads'                              => 'Descărcări',
        'Addresses'                              => 'Adrese',
        'Account details'                        => 'Detalii cont',
        'Log out'                                => 'Deconectare',
        'Logout'                                 => 'Deconectare',

        // ── My Account: dashboard ─────────────────────────────
        'Hello %s'                               => 'Bună, %s',
        'From your account dashboard you can view your %1$s, manage your %2$s and %3$s.' => 'Din panoul de cont poți vizualiza %1$s, gestiona %2$s și %3$s.',
        'recent orders'                          => 'comenzile recente',
        'shipping and billing addresses'         => 'adresele de livrare și facturare',
        'edit your password and account details' => 'schimba parola și detaliile contului',

        // ── My Account: orders table ──────────────────────────
        'Order'                                  => 'Comandă',
        'Date'                                   => 'Dată',
        'Status'                                 => 'Status',
        'Actions'                                => 'Acțiuni',
        'No order has been made yet.'            => 'Nu ai plasat nicio comandă încă.',
        'Browse products'                        => 'Explorează produsele',
        'View'                                   => 'Vizualizare',
        'View order'                             => 'Vezi comanda',
        'Pay'                                    => 'Plătește',
        'Cancel'                                 => 'Anulează',
        'Order #%s'                              => 'Comanda #%s',
        'pending payment'                        => 'în așteptarea plății',
        'processing'                             => 'în procesare',
        'on-hold'                                => 'în așteptare',
        'completed'                              => 'finalizată',
        'cancelled'                              => 'anulată',
        'refunded'                               => 'rambursată',
        'failed'                                 => 'eșuată',

        // ── My Account: addresses ─────────────────────────────
        'Billing address'                        => 'Adresă de facturare',
        'Shipping address'                       => 'Adresă de livrare',
        'Add'                                    => 'Adaugă',
        'Edit'                                   => 'Editează',
        'You have not set up this type of address yet.' => 'Nu ai adăugat încă această adresă.',

        // ── My Account: account details ───────────────────────
        'First name'                             => 'Prenume',
        'Last name'                              => 'Nume',
        'Display name'                           => 'Nume afișat',
        'This will be how your name will be displayed in the account section and in reviews' => 'Acesta va fi numele afișat în contul tău și în recenzii',
        'Password change'                        => 'Schimbare parolă',
        'Current password (leave blank to leave unchanged)' => 'Parola curentă (lasă gol pentru a nu schimba)',
        'New password (leave blank to leave unchanged)' => 'Parolă nouă (lasă gol pentru a nu schimba)',
        'Confirm new password'                   => 'Confirmă parola nouă',
        'Save changes'                           => 'Salvează modificările',

        // ── Login / Register ──────────────────────────────────
        'Username or email address'              => 'Utilizator sau adresă de email',
        'Password'                               => 'Parolă',
        'Remember me'                            => 'Ține-mă minte',
        'Log in'                                 => 'Conectare',
        'Lost your password?'                    => 'Ai uitat parola?',
        'Register'                               => 'Înregistrare',
        'Username'                               => 'Utilizator',
        'Anti-spam'                              => 'Anti-spam',
        'Already have an account? %s'            => 'Ai deja un cont? %s',

        // ── Required field notices ────────────────────────────
        'required'                               => 'obligatoriu',
        '%s is a required field.'                => '%s este un câmp obligatoriu.',
        'This field is required.'                => 'Acest câmp este obligatoriu.',
        'Please enter a valid email address.'    => 'Introduceți o adresă de email validă.',
        'Invalid email address.'                 => 'Adresă de email invalidă.',
    ];

    if ( isset( $map[ $text ] ) ) {
        return $map[ $text ];
    }

    return $translated_text;
}

add_filter( 'woocommerce_result_count', 'custom_result_count_text', 10, 2 );
function custom_result_count_text( $html, $args ) {

    if ( $args['total'] <= 1 ) {
        return gart_t('Afisare produsul');
    }

    if ( $args['total'] <= $args['per_page'] ) {
        unset($args['first']);
        unset($args['last']);
        $all_msg = gart_t('Afisare toate cele %d produse');
        return sprintf( $all_msg, $args['total'] );
    }

    $range_msg = gart_t('Afisare %1$d–%2$d din %3$d produse');
    return sprintf(
        $range_msg,
        $args['first'],
        $args['last'],
        $args['total']
    );
}

// Display 16 products per page
add_filter( 'loop_shop_per_page', 'gart_loop_shop_per_page', 20 );
function gart_loop_shop_per_page( $cols ) {
    return 16;
}

// Custom AJAX Handler for WooCommerce
add_action('wp_ajax_gart_filter_products', 'gart_ajax_filter_products');
add_action('wp_ajax_nopriv_gart_filter_products', 'gart_ajax_filter_products');

function gart_ajax_filter_products() {
    check_ajax_referer('gart_nonce', 'security');

    $paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;
    $is_load_more = isset($_POST['is_load_more']) && $_POST['is_load_more'] === 'true';

    $args = array(
        'post_type'      => 'product',
        'post_status'    => 'publish',
        'paged'          => $paged,
        'posts_per_page' => 16,
        'tax_query'      => array(
            array(
                'taxonomy' => 'product_type',
                'field'    => 'slug',
                'terms'    => 'auction',
                'operator' => 'NOT IN',
            ),
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'slug',
                'terms'    => 'licitatii',
                'operator' => 'NOT IN',
            ),
        ),
    );

    $tax_query = $args['tax_query'];

    if (!empty($_POST['product_cat'])) {
        $tax_query[] = array(
            'taxonomy' => 'product_cat',
            'field'    => 'slug',
            'terms'    => explode(',', sanitize_text_field($_POST['product_cat'])),
        );
    }
    if (!empty($_POST['pa_marime'])) {
        $tax_query[] = array(
            'taxonomy' => 'pa_marime',
            'field'    => 'slug',
            'terms'    => explode(',', sanitize_text_field($_POST['pa_marime'])),
        );
    }
    if (!empty($_POST['pa_culoare'])) {
        $tax_query[] = array(
            'taxonomy' => 'pa_culoare',
            'field'    => 'slug',
            'terms'    => explode(',', sanitize_text_field($_POST['pa_culoare'])),
        );
    }
    if (count($tax_query) > 1) {
        $args['tax_query'] = $tax_query;
    }

    if (!empty($_POST['orderby'])) {
        $orderby = sanitize_text_field($_POST['orderby']);
        $_GET['orderby'] = $orderby; // Set this so the re-rendered ordering dropdown selects the correct option
        switch ($orderby) {
            case 'price':
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'ASC';
                break;
            case 'price-desc':
                $args['meta_key'] = '_price';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;
            case 'popularity':
                $args['meta_key'] = 'total_sales';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;
            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby']  = 'meta_value_num';
                $args['order']    = 'DESC';
                break;
            case 'date':
                $args['orderby']  = 'date';
                $args['order']    = 'DESC';
                break;
            default:
                $args['orderby']  = 'menu_order title';
                $args['order']    = 'ASC';
                break;
        }
    }

    global $wp_query;
    $wp_query = new WP_Query($args);

    if ( function_exists('wc_set_loop_prop') ) {
        wc_set_loop_prop( 'total', $wp_query->found_posts );
        wc_set_loop_prop( 'total_pages', $wp_query->max_num_pages );
        wc_set_loop_prop( 'current_page', $paged );
        wc_set_loop_prop( 'per_page', 16 );
    }

    ob_start();
    
    if ( $is_load_more ) {
        if ( $wp_query->have_posts() ) {
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                wc_get_template_part( 'content', 'product' );
            }
        }
    } else {
        if ( $wp_query->found_posts > 0 ) {
            do_action( 'woocommerce_before_shop_loop' );
            woocommerce_product_loop_start();
            
            while ( $wp_query->have_posts() ) {
                $wp_query->the_post();
                do_action( 'woocommerce_shop_loop' );
                wc_get_template_part( 'content', 'product' );
            }
            
            woocommerce_product_loop_end();
            do_action( 'woocommerce_after_shop_loop' );
        } else {
            do_action( 'woocommerce_no_products_found' );
        }
    }

    $html = ob_get_clean();
    $has_next = $paged < $wp_query->max_num_pages;

    wp_reset_query();
    wp_reset_postdata();

    wp_send_json_success(array(
        'html'     => $html,
        'has_next' => $has_next,
        'current'  => $paged
    ));
}

// Custom AJAX Handler for Blog Posts Load More
add_action('wp_ajax_gart_load_more_posts', 'gart_ajax_load_more_posts');
add_action('wp_ajax_nopriv_gart_load_more_posts', 'gart_ajax_load_more_posts');

function gart_ajax_load_more_posts() {
    check_ajax_referer('gart_nonce', 'security');

    $paged = isset($_POST['paged']) ? absint($_POST['paged']) : 1;

    $args = array(
        'post_type'      => 'post',
        'post_status'    => 'publish',
        'paged'          => $paged,
        'posts_per_page' => 9,
    );

    $wp_query = new WP_Query($args);

    ob_start();
    
    if ( $wp_query->have_posts() ) {
        while ( $wp_query->have_posts() ) {
            $wp_query->the_post();
            get_template_part( 'components/blog-post' );
        }
    }

    $html = ob_get_clean();
    $has_next = $paged < $wp_query->max_num_pages;

    wp_reset_query();
    wp_reset_postdata();

    wp_send_json_success(array(
        'html'     => $html,
        'has_next' => $has_next,
    ));
}

// Translate WooCommerce breadcrumb
add_filter( 'woocommerce_breadcrumb_defaults', 'gart_custom_breadcrumb_home' );
function gart_custom_breadcrumb_home( $defaults ) {
    if ( function_exists('pll_current_language') && pll_current_language() === 'en' ) {
        $defaults['home'] = 'Home';
    } else {
        $defaults['home'] = gart_t('Acasă');
    }
    return $defaults;
}

// Global function to get formatted Romanian date
function gart_get_romanian_date() {
    $lang = function_exists('pll_current_language') ? pll_current_language() : '';
    if ( $lang === 'en' ) {
        return get_the_date('j F Y');
    }

    $months = [
        'January' => 'Ianuarie', 'February' => 'Februarie', 'March' => 'Martie',
        'April' => 'Aprilie', 'May' => 'Mai', 'June' => 'Iunie',
        'July' => 'Iulie', 'August' => 'August', 'September' => 'Septembrie',
        'October' => 'Octombrie', 'November' => 'Noiembrie', 'December' => 'Decembrie'
    ];
    $month = get_the_date('F');
    $ro_month = isset( $months[$month] ) ? $months[$month] : $month;
    return get_the_date('j') . ' ' . $ro_month . ' ' . get_the_date('Y');
}

// Remove Downloads tab from WooCommerce My Account
add_filter( 'woocommerce_account_menu_items', 'gart_remove_my_account_downloads_tab', 999 );
function gart_remove_my_account_downloads_tab( $items ) {
    unset( $items['downloads'] );
    return $items;
}

// ────── B2B User Price Reduction ──────

// Add custom field to user edit screens
add_action( 'show_user_profile', 'gart_add_b2b_user_field' );
add_action( 'edit_user_profile', 'gart_add_b2b_user_field' );
function gart_add_b2b_user_field( $user ) {
    $reduction = get_the_author_meta( 'b2b_price_reduction', $user->ID );
    ?>
    <h3>B2B Settings</h3>
    <table class="form-table">
        <tr>
            <th><label for="b2b_price_reduction">B2B Price Reduction (%)</label></th>
            <td>
                <input type="number" name="b2b_price_reduction" id="b2b_price_reduction" value="<?php echo esc_attr( $reduction ); ?>" class="regular-text" min="0" max="100" step="1" />
                <br><span class="description">Enter the discount percentage for this user (e.g. 10 for 10% discount on all products).</span>
            </td>
        </tr>
    </table>
    <?php
}

// Save the custom field
add_action( 'personal_options_update', 'gart_save_b2b_user_field' );
add_action( 'edit_user_profile_update', 'gart_save_b2b_user_field' );
function gart_save_b2b_user_field( $user_id ) {
    if ( ! current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    if ( isset( $_POST['b2b_price_reduction'] ) ) {
        update_user_meta( $user_id, 'b2b_price_reduction', intval( $_POST['b2b_price_reduction'] ) );
    }
}

// Apply the discount to the product price globally
function gart_apply_b2b_discount( $price, $product ) {
    if ( is_admin() && ! wp_doing_ajax() ) {
        return $price;
    }

    if ( ! is_user_logged_in() || empty( $price ) ) {
        return $price;
    }

    $user_id = get_current_user_id();
    $reduction = get_user_meta( $user_id, 'b2b_price_reduction', true );

    if ( ! empty( $reduction ) && is_numeric( $reduction ) && $reduction > 0 ) {
        // Calculate discounted price
        $discount_multiplier = ( 100 - $reduction ) / 100;
        $price = (float) $price * $discount_multiplier;
    }

    return $price;
}
add_filter( 'woocommerce_product_get_price', 'gart_apply_b2b_discount', 99, 2 );
add_filter( 'woocommerce_product_variation_get_price', 'gart_apply_b2b_discount', 99, 2 );

/**
 * ────── Polylang + WooCommerce Page Fixes ──────
 * Ensure cart/checkout/account URLs respect the current language.
 */
function gart_fix_woo_pages_for_polylang( $id ) {
    if ( function_exists( 'pll_get_post' ) ) {
        $translated_id = pll_get_post( $id );
        if ( $translated_id ) {
            return $translated_id;
        }
    }
    return $id;
}
add_filter( 'woocommerce_get_cart_page_id',      'gart_fix_woo_pages_for_polylang' );
add_filter( 'woocommerce_get_checkout_page_id',  'gart_fix_woo_pages_for_polylang' );
add_filter( 'woocommerce_get_myaccount_page_id', 'gart_fix_woo_pages_for_polylang' );
add_filter( 'woocommerce_get_terms_page_id',     'gart_fix_woo_pages_for_polylang' );

/**
 * ────── Polylang + WooCommerce: Page Recognition ──────
 * Ensure is_cart(), is_checkout(), and is_account_page() return true for translations.
 */
function gart_woo_fix_is_functions( $is_page, $page_type ) {
    if ( ! $is_page && function_exists( 'pll_get_post' ) ) {
        $core_id = wc_get_page_id( $page_type );
        if ( is_page( pll_get_post( $core_id ) ) ) {
            return true;
        }
    }
    return $is_page;
}
add_filter( 'woocommerce_is_cart',         function($is) { return gart_woo_fix_is_functions($is, 'cart'); });
add_filter( 'woocommerce_is_checkout',     function($is) { return gart_woo_fix_is_functions($is, 'checkout'); });
add_filter( 'woocommerce_is_account_page', function($is) { return gart_woo_fix_is_functions($is, 'myaccount'); });


/**
 * ────── Polylang + WooCommerce: Prevent Core Redirects ──────
 * Forcefully stop WooCommerce from redirecting English pages back to Romanian.
 */
add_action( 'template_redirect', 'gart_prevent_woo_polylang_redirects', 1 );
function gart_prevent_woo_polylang_redirects() {
    if ( ! function_exists( 'pll_get_post' ) ) return;

    $cart_id     = wc_get_page_id( 'cart' );
    $checkout_id = wc_get_page_id( 'checkout' );
    $account_id  = wc_get_page_id( 'myaccount' );

    $is_en_page = is_page( pll_get_post($cart_id) ) || 
                  is_page( pll_get_post($checkout_id) ) || 
                  is_page( pll_get_post($account_id) );

    if ( $is_en_page ) {
        // Stop WooCommerce from redirecting based on its internal page settings
        remove_action( 'template_redirect', array( 'WC_Query', 'checkout_redirect' ) );
        remove_action( 'template_redirect', 'wc_checkout_redirect', 10 );
    }
}

// Fix caching issue for variable products
add_filter( 'woocommerce_get_variation_prices_hash', 'gart_b2b_variation_prices_hash', 10, 3 );
function gart_b2b_variation_prices_hash( $price_hash, $product, $for_display ) {
    if ( is_user_logged_in() ) {
        $user_id = get_current_user_id();
        $reduction = get_user_meta( $user_id, 'b2b_price_reduction', true );
        if ( ! empty( $reduction ) && is_numeric( $reduction ) && $reduction > 0 ) {
            $price_hash[] = 'b2b_' . $reduction;
        }
    }
    return $price_hash;
}

// Enable Polylang for WooCommerce Products and Taxonomies
add_filter( 'pll_get_post_types', function( $post_types, $is_settings ) {
    $post_types['product'] = 'product';
    return $post_types;
}, 10, 2 );

add_filter( 'pll_get_taxonomies', function( $taxonomies, $is_settings ) {
    $taxonomies['product_cat'] = 'product_cat';
    $taxonomies['product_tag'] = 'product_tag';
    $taxonomies['pa_marime']   = 'pa_marime';
    $taxonomies['pa_culoare']  = 'pa_culoare';
    return $taxonomies;
}, 10, 2 );

// Force allow core slugs for translations (prevents cart-2, shop-2, etc.)
add_filter( 'wp_unique_post_slug', function( $slug, $post_ID, $post_status, $post_type, $post_parent, $original_slug ) {
    $allowed_slugs = array( 'shop', 'cart', 'checkout', 'my-account', 'cos', 'finalizare-comanda', 'contul-meu' );
    if ( in_array( $original_slug, $allowed_slugs ) && $post_type === 'page' ) {
        return $original_slug;
    }
    return $slug;
}, 10, 6 );