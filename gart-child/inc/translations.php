<?php
/**
 * Polylang String Registration – Gart Child
 */
add_action('init', function() {
    if ( function_exists('pll_register_string') ) {
        
        $group = 'Gart Theme';

        // ────── WooCommerce Custom Strings ──────
        pll_register_string('Add to cart link', 'ADAUGĂ ÎN COȘ', $group);
        pll_register_string('Add to favorites btn', 'ADAUGĂ LA FAVORITE', $group);
        pll_register_string('View cart link', 'Vezi coșul', $group);
        pll_register_string('Similar products title', 'Produse Similare', $group);
        pll_register_string('Home Breadcrumb label', 'Acasă', $group);
        pll_register_string('Display product count singular', 'Afisare produsul', $group);
        pll_register_string('Display all products count', 'Afisare toate cele %d produse', $group);
        pll_register_string('Display result count range', 'Afisare %1$d–%2$d din %3$d produse', $group);

        // ────── Account & AJAX Strings ──────
        pll_register_string('Required fields err', 'Toate câmpurile sunt obligatorii.', $group);
        pll_register_string('Invalid email err', 'Adresă de email invalidă.', $group);
        pll_register_string('User exists err', 'Numele de utilizator sau emailul este deja folosit.', $group);
        pll_register_string('Register success msg', 'Înregistrare cu succes!', $group);
        pll_register_string('Login success msg', 'Autentificare cu succes!', $group);
        pll_register_string('Login failed err', 'Autentificare eșuată. Verificați datele și încercați din nou.', $group);
        pll_register_string('Reset pwd prompt msg', 'Vă rugăm să introduceți un nume de utilizator sau o adresă de email.', $group);
        pll_register_string('User not found err', 'Nu există niciun cont cu acest nume de utilizator sau adresă de email.', $group);
        pll_register_string('Email error msg', 'A apărut o eroare la trimiterea emailului de resetare.', $group);
        pll_register_string('Email sent success msg', 'Un email de resetare a parolei a fost trimis.', $group);

        // ────── JS Localized Strings ──────
        pll_register_string('JS Auth title', 'Autentificare', $group);
        pll_register_string('JS Register title', 'Înregistrare', $group);
        pll_register_string('JS Lost Pass title', 'Recuperare Parolă', $group);
        pll_register_string('JS User/Email label', 'Nume utilizator sau adresă email *', $group);
        pll_register_string('JS Password label', 'Parolă *', $group);
        pll_register_string('JS Remember me label', 'Ține-mă minte', $group);
        pll_register_string('JS Create account link', 'Creează cont', $group);
        pll_register_string('JS Lost pass link', 'Ți-ai pierdut parola?', $group);
        pll_register_string('JS Username label', 'Nume utilizator *', $group);
        pll_register_string('JS Email label', 'Email *', $group);
        pll_register_string('JS Already account link', 'Ai deja un cont? Autentificare', $group);
        pll_register_string('JS Back to login link', 'Înapoi la Autentificare', $group);
        pll_register_string('JS Wait msg', 'Vă rugăm așteptați...', $group);
        pll_register_string('JS Error msg', 'A apărut o eroare.', $group);
        pll_register_string('JS Request error msg', 'O eroare a apărut la procesarea solicitării.', $group);
        pll_register_string('JS Loading msg', 'Se încarcă...', $group);
        pll_register_string('JS No products found msg', 'Niciun produs găsit.', $group);
        pll_register_string('JS Reset pass btn', 'Resetare Parolă', $group);
        pll_register_string('JS Success msg', 'Succes!', $group);

        // ────── Wishlist Plugin Strings ──────
        pll_register_string('Wishlist empty msg', 'Nu ai adaugat niciun produs la favorite inca.', $group);
        pll_register_string('Wishlist Product header', 'Produs', $group);
        pll_register_string('Wishlist Price header', 'Pret', $group);
        pll_register_string('Wishlist Stock header', 'Stoc', $group);
        pll_register_string('Wishlist In Stock status', 'In Stoc', $group);
        pll_register_string('Wishlist Out of stock status', 'Stoc Epuizat', $group);
        pll_register_string('Wishlist Remove label', 'Sterge articol', $group);

        // ────── Auction Plugin Strings ──────
        pll_register_string('Auction Ended msg', 'Licitație încheiată', $group);
        pll_register_string('Auction Ends in label', 'Se încheie în:', $group);
        pll_register_string('Auction Current bid label', 'Bid curent:', $group);
        pll_register_string('Auction Place bid btn', 'Plasează Bid', $group);
        pll_register_string('Auction Min bid hint', 'Minimum bid: %s', $group);
        pll_register_string('Auction Winner label', 'Câștigător: <strong>%s</strong>', $group);
        pll_register_string('Auction Congratulations msg', 'Felicitări! Ai câștigat această licitație.', $group);
        pll_register_string('Auction Add to cart btn', 'Adaugă în coș', $group);
        pll_register_string('Auction No valid bids msg', 'Nicio ofertă validă.', $group);
        pll_register_string('Auction History title', 'Istoric Licitație', $group);
        pll_register_string('Auction No bids msg', 'Niciun bid momentan.', $group);
        pll_register_string('Auction Must login msg', 'Trebuie să fii autentificat pentru a licita.', $group);
        pll_register_string('Auction Invalid bid msg', 'Bid nevalid.', $group);
        pll_register_string('Auction Already ended msg', 'Licitația s-a încheiat deja.', $group);
        pll_register_string('Auction Bid threshold msg', 'Bidul trebuie să fie cel puțin %s.', $group);
        pll_register_string('Auction Bid success msg', 'Bid plasat cu succes!', $group);
        pll_register_string('Auction Win button text', 'Câștigă Licitația', $group);

        // ────── Theme UI Strings ──────
        pll_register_string('Load more btn', 'Încarcă mai multe', $group);
        pll_register_string('All rights reserved copyright', 'Toate drepturile rezervate.', $group);

        // ────── Filter Strings ──────
        pll_register_string('Filter title', 'Filtre', $group);
        pll_register_string('Filter reset', 'Resetează', $group);
        pll_register_string('Filter Category title', 'CATEGORIE', $group);
        pll_register_string('Filter Size title', 'MĂRIME', $group);
        pll_register_string('Filter Color title', 'CULOARE', $group);
    }
});

/**
 * Programmatic English translations for all pll__() strings.
 * This provides instant fallback translations without requiring
 * manual entry in the Polylang admin String Translations page.
 */
add_filter( 'pll__', 'gart_pll_english_translations' );
function gart_pll_english_translations( $translation ) {
    if ( ! function_exists('pll_current_language') || pll_current_language() !== 'en' ) {
        return $translation;
    }

    $en = array(
        // ── Theme UI ──
        'Toate drepturile rezervate.'                           => 'All rights reserved.',
        'Încarcă mai multe'                                     => 'Load more',
        'Filtre'                                                => 'Filters',
        'Resetează'                                             => 'Reset',
        'CATEGORIE'                                             => 'CATEGORY',
        'MĂRIME'                                                => 'SIZE',
        'CULOARE'                                               => 'COLOR',

        // ── WooCommerce Custom ──
        'ADAUGĂ ÎN COȘ'                                        => 'ADD TO CART',
        'ADAUGĂ LA FAVORITE'                                    => 'ADD TO WISHLIST',
        'Vezi coșul'                                            => 'View cart',
        'Produse Similare'                                      => 'Similar Products',
        'Acasă'                                                 => 'Home',
        'Afisare produsul'                                      => 'Showing the product',
        'Afisare toate cele %d produse'                         => 'Showing all %d products',
        'Afisare %1$d–%2$d din %3$d produse'                   => 'Showing %1$d–%2$d of %3$d products',
        '%s a fost adăugat în coșul tău.'                       => '%s has been added to your cart.',

        // ── Account & AJAX ──
        'Toate câmpurile sunt obligatorii.'                     => 'All fields are required.',
        'Adresă de email invalidă.'                             => 'Invalid email address.',
        'Numele de utilizator sau emailul este deja folosit.'   => 'Username or email already in use.',
        'Înregistrare cu succes!'                               => 'Registration successful!',
        'Autentificare cu succes!'                              => 'Login successful!',
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

        // ── Auction ──
        'Licitație încheiată'                                   => 'Auction ended',
        'Se încheie în:'                                        => 'Ends in:',
        'Bid curent:'                                           => 'Current bid:',
        'Plasează Bid'                                          => 'Place Bid',
        'Minimum bid: %s'                                       => 'Minimum bid: %s',
        'Câștigător: <strong>%s</strong>'                       => 'Winner: <strong>%s</strong>',
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
    );

    return isset( $en[ $translation ] ) ? $en[ $translation ] : $translation;
}
