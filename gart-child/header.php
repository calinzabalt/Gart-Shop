<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<?php 
    $header_top = gart_get_option('header_top');
    $drawer_title = gart_get_option('drawer_title');
    $social_icons_title = gart_get_option('social_icons_title');
    $social_icons = gart_get_option('social_icons');
?>

<header class="header">
    <div class="top_bar">
        <div class="container">
            <p><?php echo $header_top;?></p>
        </div>
    </div>
    <div class="container">        
        <button id="drawer-toggle" class="drawer-toggle" aria-label="Open menu">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="bars" role="img" viewBox="0 0 448 512"><path fill="currentColor" d="M0 96C0 78.3 14.3 64 32 64l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 128C14.3 128 0 113.7 0 96zM0 256c0-17.7 14.3-32 32-32l384 0c17.7 0 32 14.3 32 32s-14.3 32-32 32L32 288c-17.7 0-32-14.3-32-32zM448 416c0 17.7-14.3 32-32 32L32 448c-17.7 0-32-14.3-32-32s14.3-32 32-32l384 0c17.7 0 32 14.3 32 32z"></path></svg>
        </button>

        <nav class="main-nav flex item-center">
            <div class="nav-left">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_left',
                    'container' => false,
                ]);
                ?>
            </div>

            <div class="nav-logo">
                <a href="<?php echo esc_url( function_exists('pll_home_url') ? pll_home_url() : home_url( '/' ) ); ?>">
                    <svg version="1.0" width="322.000000pt" height="421.000000pt" viewBox="0 0 322.000000 421.000000" preserveAspectRatio="xMidYMid meet">
                        <g transform="translate(0.000000,421.000000) scale(0.100000,-0.100000)" fill="#000000" stroke="none">
                        <path d="M755 4189 c-110 -7 -155 -19 -270 -74 -65 -32 -111 -63 -168 -115 -90 -83 -196 -237 -222 -320 -9 -30 -21 -64 -25 -75 -54 -128 -63 -341 -20 -495 11 -41 25 -92 30 -112 9 -35 37 -90 82 -165 19 -33 19 -33 0 -60 -62 -89 -119 -254 -132 -388 -15 -150 16 -338 82 -485 59 -133 226 -322 329 -372 174 -86 240 -101 406 -95 137 5 181 11 228 31 17 7 56 23 89 36 72 29 143 81 201 149 45 53 120 169 113 176 -2 2 -22 7 -43 10 l-40 7 -44 -72 c-47 -77 -141 -157 -231 -199 -172 -78 -412 -83 -562 -12 -181 86 -278 186 -373 381 -30 61 -37 84 -64 186 -13 50 -15 304 -2 336 5 13 15 43 22 68 16 57 80 190 92 190 5 0 26 -17 47 -37 57 -56 153 -131 191 -148 19 -9 48 -24 66 -35 59 -35 213 -59 343 -53 184 9 314 61 461 185 26 22 54 38 61 36 9 -4 13 -32 14 -104 1 -54 3 -112 5 -129 l4 -30 -204 -3 -203 -2 6 -31 c3 -18 6 -35 6 -40 0 -5 105 -9 234 -9 178 0 235 3 238 13 3 6 4 224 4 482 l-1 470 -242 3 -243 2 0 -40 0 -40 63 -1 c34 -1 125 -4 202 -8 125 -5 140 -8 139 -23 0 -10 -1 -70 -2 -133 -2 -87 -5 -115 -15 -115 -7 0 -38 22 -70 48 -70 60 -209 138 -261 147 -21 3 -46 10 -55 15 -28 15 -158 26 -175 15 -10 -6 -19 -6 -26 1 -20 20 -245 -27 -318 -67 -94 -52 -100 -57 -218 -162 -24 -21 -47 -36 -51 -34 -20 12 -83 159 -102 236 -66 265 18 577 207 768 75 76 216 173 252 173 9 0 20 3 24 8 15 15 166 27 273 20 177 -10 273 -51 401 -172 24 -23 52 -59 63 -81 37 -74 43 -78 93 -71 26 4 46 9 46 11 0 6 -34 65 -65 114 -14 23 -58 73 -99 113 -60 60 -88 80 -160 111 -47 20 -97 37 -109 37 -13 0 -28 5 -33 10 -15 15 -165 26 -269 19z m256 -1129 c113 -35 227 -100 306 -174 40 -38 73 -74 73 -81 0 -29 -149 -151 -242 -197 -103 -52 -132 -62 -228 -76 -84 -13 -89 -13 -190 4 -151 25 -322 122 -411 235 l-32 41 68 68 c37 38 89 79 114 91 25 13 48 26 51 29 10 12 85 43 144 60 89 26 264 26 347 0z"/>
                        <path d="M2265 4189 c-93 -9 -234 -53 -319 -100 -70 -38 -164 -130 -218 -213 -49 -75 -49 -92 -1 -99 44 -8 48 -5 73 41 47 89 176 193 302 243 83 33 83 33 263 34 230 0 279 -15 445 -136 72 -52 179 -177 217 -254 30 -60 70 -200 83 -290 18 -118 -1 -283 -39 -355 -5 -9 -12 -31 -16 -50 -8 -34 -49 -109 -68 -121 -5 -4 -37 21 -71 55 -56 55 -164 135 -222 165 -12 6 -44 18 -70 26 -27 9 -58 20 -69 25 -75 32 -346 32 -420 0 -11 -5 -49 -18 -84 -30 -75 -23 -191 -93 -240 -144 -19 -20 -43 -36 -53 -36 -16 0 -18 11 -18 130 l0 130 203 2 202 3 3 38 3 37 -253 -2 -253 -3 -3 -340 c-2 -187 -1 -400 3 -473 l7 -132 242 2 241 3 0 35 0 35 -195 5 -195 5 -3 128 c-1 74 1 127 7 127 5 0 48 -29 96 -65 168 -125 299 -169 510 -169 96 -1 150 4 205 18 117 30 137 40 307 154 18 12 50 40 69 62 19 21 41 37 48 34 18 -7 63 -108 83 -189 22 -87 24 -302 5 -390 -39 -170 -97 -280 -213 -396 -76 -77 -173 -138 -284 -177 -85 -31 -245 -41 -333 -22 -118 26 -148 34 -162 40 -8 4 -28 14 -45 21 -47 20 -161 109 -193 148 -15 20 -39 54 -52 76 -13 22 -25 42 -26 43 -4 7 -74 -22 -74 -30 0 -10 36 -74 72 -126 60 -87 204 -187 313 -217 85 -23 220 -44 290 -45 117 0 292 46 388 104 100 61 157 115 283 269 8 9 14 21 14 26 0 4 15 39 34 77 131 262 127 555 -11 801 -28 51 -29 78 -3 123 103 181 140 304 140 469 0 180 -40 311 -151 496 -46 77 -149 188 -214 232 -60 40 -162 89 -230 111 -83 26 -201 42 -214 29 -5 -5 -17 -5 -29 2 -11 6 -22 10 -24 10 -2 -1 -39 -5 -83 -10z m214 -1094 c83 -16 195 -67 291 -133 56 -37 150 -135 150 -155 0 -17 -57 -78 -120 -129 -73 -58 -224 -125 -338 -147 -167 -34 -386 24 -556 146 -57 41 -146 129 -146 144 0 14 129 139 144 139 7 0 30 13 50 29 48 38 171 89 255 106 90 18 174 18 270 0z"/>
                        <path d="M615 849 c-94 -8 -158 -22 -212 -45 -85 -36 -109 -51 -159 -97 -87 -79 -114 -143 -115 -268 0 -75 3 -95 29 -150 31 -67 98 -140 162 -175 89 -50 143 -64 280 -73 207 -12 319 4 400 56 45 30 52 29 69 -8 15 -34 53 -53 88 -44 l23 5 -2 207 -3 207 -205 -2 -205 -2 0 -28 0 -27 132 -3 131 -3 7 -47 c15 -116 -11 -167 -113 -218 -54 -27 -63 -28 -203 -28 -89 -1 -155 3 -170 10 -13 7 -44 20 -68 30 -66 28 -134 99 -157 164 -28 82 -24 208 9 281 26 58 87 129 112 129 8 0 15 5 15 10 0 6 8 10 18 10 10 0 22 4 28 9 46 41 339 48 484 11 25 -6 68 -15 97 -19 44 -6 52 -4 56 10 6 24 -11 49 -34 49 -10 0 -27 4 -37 9 -31 16 -109 30 -193 36 -46 3 -104 7 -129 9 -25 2 -85 0 -135 -5z"/>
                        <path d="M2820 831 c0 -11 -4 -23 -10 -26 -5 -3 -10 -15 -10 -26 0 -10 -4 -27 -9 -37 -5 -9 -13 -30 -18 -47 -8 -29 -10 -30 -78 -33 -39 -2 -100 2 -137 9 -54 10 -77 10 -110 0 -70 -20 -104 -39 -136 -76 -34 -38 -42 -34 -52 25 l-5 35 -63 3 -62 3 0 -274 c0 -199 -3 -276 -12 -285 -7 -7 -31 -12 -53 -12 -72 0 -75 9 -75 221 0 156 -3 192 -19 233 -19 51 -63 96 -93 96 -9 0 -19 4 -22 9 -3 5 -57 14 -121 21 -115 12 -164 9 -295 -21 -87 -21 -100 -29 -100 -61 0 -27 3 -30 23 -23 82 25 137 38 220 51 38 7 140 -9 189 -29 14 -6 33 -26 42 -44 19 -40 21 -129 4 -140 -7 -4 -53 -11 -103 -14 -216 -17 -316 -39 -401 -91 -61 -36 -90 -87 -80 -136 8 -34 33 -60 91 -93 37 -22 51 -23 210 -24 155 0 174 2 217 22 25 12 49 27 53 33 12 20 43 10 49 -15 4 -15 17 -30 32 -35 18 -7 254 -7 397 0 4 0 7 101 7 224 l0 224 33 32 c63 63 180 89 266 59 25 -9 38 -9 55 0 12 7 42 11 67 9 l44 -3 6 -215 c3 -118 10 -228 15 -244 27 -80 138 -114 313 -96 52 6 97 12 99 15 2 2 1 16 -2 31 -6 23 -10 25 -39 20 -125 -24 -176 -15 -208 38 -17 28 -19 52 -19 238 0 243 -19 217 160 221 l115 2 0 25 0 25 -137 3 -138 3 0 94 0 95 -50 0 c-43 0 -50 -3 -50 -19z m-992 -561 c3 -82 2 -87 -25 -112 -38 -36 -142 -68 -221 -68 -49 0 -76 6 -115 26 -61 30 -67 38 -67 85 0 24 7 42 23 56 31 29 110 60 187 72 36 6 88 15 115 20 28 5 61 8 75 8 24 -2 25 -4 28 -87z"/>
                        </g>
                    </svg>
                </a>
            </div>

            <div class="nav-right">
                <?php
                wp_nav_menu([
                    'theme_location' => 'menu_right',
                    'container' => false,
                ]);
                ?>
            </div>

            <div class="shop-header-icons flex item-center" style="gap: 20px;">
                <?php if ( class_exists( 'WooCommerce' ) && ( is_woocommerce() || is_cart() || is_checkout() || is_account_page() ) ) : ?>
                    <?php 
                    $account_id = wc_get_page_id('myaccount');
                    if ( function_exists('pll_get_post') ) {
                        $account_id = pll_get_post($account_id) ?: $account_id;
                    }
                    $account_link = get_permalink( $account_id );
                    $account_class = 'shop-icon';
                    if ( ! is_user_logged_in() ) {
                        $account_class .= ' login-link';
                    }
                    ?>
                    <a href="<?php echo esc_url( $account_link ); ?>" class="<?php echo esc_attr( $account_class ); ?>" title="My Account">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </a>
                    <?php 
                    $cart_id = wc_get_page_id('cart');
                    $cart_url = get_permalink($cart_id);
                    ?>
                    <a href="<?php echo esc_url( $cart_url ); ?>" class="shop-icon relative" title="Cart">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                        </svg>
                        <?php if ( WC()->cart ) : 
                            $cart_count = WC()->cart->get_cart_contents_count();
                        ?>
                            <span class="cart-count <?php echo ($cart_count > 0) ? 'is-visible' : ''; ?>"><?php echo $cart_count; ?></span>
                        <?php endif; ?>
                    </a>
                    <?php 
                    $wishlist_url = home_url( '/wishlist' );
                    $wishlist_page = get_page_by_path('wishlist');
                    if ( $wishlist_page ) {
                        $wishlist_id = function_exists('pll_get_post') ? pll_get_post($wishlist_page->ID) : $wishlist_page->ID;
                        $wishlist_url = get_permalink($wishlist_id);
                    }
                    ?>
                    <a href="<?php echo esc_url( $wishlist_url ); ?>" class="shop-icon wishlist-trigger relative" title="Wishlist">
                        <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" width="22" height="22">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                        </svg>
                        <span class="wishlist-count <?php echo (gart_get_wishlist_count() > 0) ? 'is-visible' : ''; ?>">
                            <?php echo gart_get_wishlist_count(); ?>
                        </span>
                    </a>
                <?php endif; ?>

                <?php if ( function_exists( 'pll_the_languages' ) ) : 
                    $languages = pll_the_languages( array( 'raw' => 1 ) );
                    if ( $languages ) :
                        $current = null;
                        foreach($languages as $l) if($l['current_lang']) $current = $l;
                        if (!$current) $current = reset($languages);
                ?>
                        <div class="lang-dropdown">
                            <div class="lang-current flex item-center">
                                <img src="<?php echo $current['flag']; ?>" alt="<?php echo $current['name']; ?>">
                            </div>
                            <ul class="lang-list">
                            <?php foreach($languages as $lang): ?>
                                <?php if(!$lang['current_lang']): ?>
                                    <li>
                                        <a href="<?php echo $lang['url']; ?>" class="flex item-center">
                                            <img src="<?php echo $lang['flag']; ?>" alt="<?php echo $lang['name']; ?>">
                                            <span><?php echo strtoupper($lang['slug']); ?></span>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; endif; ?>
            </div>
        </nav>
    </div>
</header>

<div class="drawer">
    <div class="drawer_wrapper">
        <div class="drawer_title">
            <?php echo $drawer_title;?>
        </div>
        <div class="drawer_close">
            <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="xmark" role="img" viewBox="0 0 384 512"><path fill="currentColor" d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"></path></svg>
        </div>

        <?php
        wp_nav_menu([
            'theme_location' => 'menu_left',
            'container' => false,
        ]);
        ?>
        <?php
        wp_nav_menu([
            'theme_location' => 'menu_right',
            'container' => false,
        ]);
        ?>

        <div class="social_media">
            <span><?php echo $social_icons_title; ?></span>
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