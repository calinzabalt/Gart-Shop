<?php
/**
 * Gart Child – Functions
 * Author: Cozma Calin
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
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
        'nonce' => wp_create_nonce('gart_nonce')
    ) );
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

// ────── Secure AJAX Login ──────
add_action( 'wp_ajax_nopriv_gart_login', 'gart_ajax_login' );
add_action( 'wp_ajax_gart_login', 'gart_ajax_login' );
function gart_ajax_login() {
    check_ajax_referer( 'gart_nonce', 'security' );

    $username = isset($_POST['username']) ? sanitize_user($_POST['username'], true) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']) ? true : false;

    if ( empty($username) || empty($password) ) {
        wp_send_json_error( array('message' => 'Toate câmpurile sunt obligatorii.') );
    }

    $user = wp_signon( array(
        'user_login'    => $username,
        'user_password' => $password,
        'remember'      => $remember
    ), is_ssl() );

    if ( is_wp_error($user) ) {
        wp_send_json_error( array('message' => 'Autentificare eșuată. Verificați datele și încercați din nou.') );
    }

    wp_send_json_success( array('message' => 'Autentificare cu succes!') );
}

// ────── Secure AJAX Lost Password ──────
add_action( 'wp_ajax_nopriv_gart_lost_password', 'gart_ajax_lost_password' );
add_action( 'wp_ajax_gart_lost_password', 'gart_ajax_lost_password' );
function gart_ajax_lost_password() {
    check_ajax_referer( 'gart_nonce', 'security' );

    $user_login = isset($_POST['user_login']) ? sanitize_user($_POST['user_login']) : '';

    if ( empty($user_login) ) {
        wp_send_json_error( array('message' => 'Vă rugăm să introduceți un nume de utilizator sau o adresă de email.') );
    }

    $user_data = get_user_by( 'email', $user_login );
    if ( ! $user_data ) {
        $user_data = get_user_by( 'login', $user_login );
    }

    if ( ! $user_data ) {
        wp_send_json_error( array('message' => 'Nu există niciun cont cu acest nume de utilizator sau adresă de email.') );
    }

    $result = retrieve_password( $user_login );

    if ( is_wp_error( $result ) ) {
        wp_send_json_error( array('message' => 'A apărut o eroare la trimiterea emailului de resetare.') );
    }

    wp_send_json_success( array('message' => 'Un email de resetare a parolei a fost trimis.') );
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
        wp_send_json_error( array('message' => 'Toate câmpurile sunt obligatorii.') );
    }

    if ( !is_email($email) ) {
        wp_send_json_error( array('message' => 'Adresă de email invalidă.') );
    }

    if ( username_exists($username) || email_exists($email) ) {
        wp_send_json_error( array('message' => 'Numele de utilizator sau emailul este deja folosit.') );
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

    wp_send_json_success( array('message' => 'Înregistrare cu succes!') );
}

add_action('acf/init', function() {
    // Safety check in case ACF isn't active
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'    => 'Theme Settings',
            'menu_title'    => 'Theme Settings',
            'menu_slug'     => 'theme-settings',
            'capability'    => 'edit_posts',
            'redirect'      => false,
            'position'      => 5,
            'icon_url'      => 'dashicons-admin-customizer',
            'updated_message' => __('Theme settings updated.', 'your-text-domain'),
        ]);
    }
});

// Translate specific WooCommerce strings
add_filter('gettext', 'gart_translate_woocommerce_strings', 999, 3);
function gart_translate_woocommerce_strings($translated_text, $text, $domain) {
    if (is_admin() && !wp_doing_ajax()) {
        return $translated_text;
    }

    switch ($text) {
        case 'Default sorting':
            return 'Sortare implicită';
        case 'Sort by popularity':
            return 'Sortare după popularitate';
        case 'Sort by average rating':
            return 'Sortare după evaluare medie';
        case 'Sort by latest':
            return 'Sortare după cele mai recente';
        case 'Sort by price: low to high':
            return 'Sortare după preț: crescător';
        case 'Sort by price: high to low':
            return 'Sortare după preț: descrescător';
    }

    return $translated_text;
}

add_filter( 'woocommerce_result_count', 'custom_result_count_text', 10, 2 );
function custom_result_count_text( $html, $args ) {

    if ( $args['total'] <= 1 ) {
        return 'Afisare produsul';
    }

    if ( $args['total'] <= $args['per_page'] ) {
        return sprintf( 'Afisare toate cele %d produse', $args['total'] );
    }

    return sprintf(
        'Afisare %1$d–%2$d din %3$d produse',
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
    );

    $tax_query = array('relation' => 'AND');

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

// Translate WooCommerce breadcrumb "Home" to Romanian ("Acasă")
add_filter( 'woocommerce_breadcrumb_defaults', 'gart_custom_breadcrumb_home' );
function gart_custom_breadcrumb_home( $defaults ) {
    $defaults['home'] = 'Acasă';
    return $defaults;
}

// Global function to get formatted Romanian date
function gart_get_romanian_date() {
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