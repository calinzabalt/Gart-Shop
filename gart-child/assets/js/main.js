jQuery(function($) {
    "use strict";

    // Open Login modal
    $(document).on('click', '.login-link', function(e) {
        e.preventDefault();
        $('#modal-forms').html(`
            <h3>Login</h3>
            <form id="loginform">
                <p><input type="text" name="username" placeholder="Username or Email" required></p>
                <p><input type="password" name="password" placeholder="Password" required></p>
                <p><button type="submit">Login</button></p>
                <input type="hidden" name="action" value="gart_login">
                <input type="hidden" name="security" value="${gart_ajax.nonce}">
            </form>
        `);
        $('#login-register-modal').addClass('active');
    });

    // Open Register modal
    $(document).on('click', '.register-link', function(e) {
        e.preventDefault();
        $('#modal-forms').html(`
            <h3>Register</h3>
            <form id="registerform">
                <p><input type="text" name="username" placeholder="Username" required></p>
                <p><input type="email" name="email" placeholder="Email" required></p>
                <p><input type="password" name="password" placeholder="Password" required></p>
                <p><button type="submit">Register</button></p>
                <input type="hidden" name="action" value="gart_register">
                <input type="hidden" name="security" value="${gart_ajax.nonce}">
            </form>
        `);
        $('#login-register-modal').addClass('active');
    });

    // Submit forms
    $(document).on('submit', '#loginform, #registerform', function(e) {
        e.preventDefault();
        $.post(gart_ajax.url, $(this).serialize(), function(res) {
            alert(res.data.message);
            if (res.success) location.reload();
        }, 'json');
    });

    // Close modal
    $(document).on('click', '.close-modal, #login-register-modal', function(e) {
        if (e.target === this) {
            $('#login-register-modal').removeClass('active');
        }
    });

    // ==================== DRAWER ====================
    const $toggle     = $('#drawer-toggle');
    const $drawer     = $('.drawer');
    const $close      = $('.drawer_close');
    const $body       = $('body');

    let $backdrop = $('#drawer-backdrop');
    if ($backdrop.length === 0) {
        $backdrop = $('<div id="drawer-backdrop" class="drawer-backdrop"></div>');
        $('body').append($backdrop);
    }

    // Open drawer
    $toggle.on('click', function(e) {
        e.preventDefault();
        openDrawer();
    });

    // Close events
    $close.on('click', closeDrawer);
    $backdrop.on('click', closeDrawer);

    // Close with Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape' && $drawer.hasClass('is-open')) {
            closeDrawer();
        }
    });

    // Close menu links after click (with small delay)
    $drawer.find('a').on('click', function() {
        setTimeout(closeDrawer, 150);
    });

    function openDrawer() {
        $drawer.addClass('is-open');
        $backdrop.addClass('is-visible');
        $body.addClass('drawer-open');
    }

    function closeDrawer() {
        $drawer.removeClass('is-open');
        $backdrop.removeClass('is-visible');
        $body.removeClass('drawer-open');
    }

    $(window).on('scroll', function() {
        if ($(window).scrollTop() > 100) {
            $('.header').addClass('sticky');
        } else {
            $('.header').removeClass('sticky');
        }
    });

});