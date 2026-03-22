jQuery(function ($) {
    "use strict";

    let $backdrop = $('#drawer-backdrop');
    if ($backdrop.length === 0) {
        $backdrop = $('<div id="drawer-backdrop" class="drawer-backdrop"></div>');
        $('body').append($backdrop);
    }

    // Open Login modal
    $(document).on('click', '.login-link', function (e) {
        e.preventDefault();
        $('#modal-forms').html(`
            <h3>Autentificare</h3>
            <form id="loginform">
                <p><label>Nume utilizator sau adresă email *</label><input type="text" name="username" required></p>
                <p><label>Parolă *</label><input type="password" name="password" required></p>
                <p><label><input type="checkbox" name="remember" value="forever"> Ține-mă minte</label></p>
                <p><button type="submit">Autentificare</button></p>
                <input type="hidden" name="action" value="gart_login">
                <input type="hidden" name="security" value="${gart_ajax.nonce}">
                <div class="modal-content-footer">
                    <a href="#" class="register-link">Creează cont</a>
                    <a href="#" class="lost-pass-link">Ți-ai pierdut parola?</a>
                </div>
            </form>
        `);
        $('#login-register-modal').addClass('active');
        $backdrop.addClass('is-visible');
    });

    // Open Register modal
    $(document).on('click', '.register-link', function (e) {
        e.preventDefault();
        $('#modal-forms').html(`
            <h3>Înregistrare</h3>
            <form id="registerform">
                <p><label>Nume utilizator *</label><input type="text" name="username" required></p>
                <p><label>Email *</label><input type="email" name="email" required></p>
                <p><label>Parolă *</label><input type="password" name="password" required></p>
                <p><button type="submit">Înregistrare</button></p>
                <input type="hidden" name="action" value="gart_register">
                <input type="hidden" name="security" value="${gart_ajax.nonce}">
                <div class="modal-content-footer">
                    <a href="#" class="login-link">Ai deja un cont? Autentificare</a>
                </div>
            </form>
        `);
        $('#login-register-modal').addClass('active');
        $backdrop.addClass('is-visible');
    });

    // Open Lost Password modal
    $(document).on('click', '.lost-pass-link', function (e) {
        e.preventDefault();
        $('#modal-forms').html(`
            <h3>Recuperare Parolă</h3>
            <form id="lostpasswordform">
                <p><label>Nume utilizator sau adresă email *</label><input type="text" name="user_login" required></p>
                <p><button type="submit">Resetare Parolă</button></p>
                <input type="hidden" name="action" value="gart_lost_password">
                <input type="hidden" name="security" value="${gart_ajax.nonce}">
                <div class="modal-content-footer">
                    <a href="#" class="login-link">Înapoi la Autentificare</a>
                </div>
            </form>
        `);
    });

    // Submit forms
    $(document).on('submit', '#loginform, #registerform, #lostpasswordform', function (e) {
        e.preventDefault();
        
        let $form = $(this);
        let $btn = $form.find('button[type="submit"]');
        let originalBtnText = $btn.text();
        
        // Remove existing messages
        $form.prev('.gart-form-message').remove();
        
        // Loading state
        $btn.prop('disabled', true).text('Vă rugăm așteptați...');
        
        $.ajax({
            url: gart_ajax.url,
            type: 'POST',
            data: $form.serialize(),
            dataType: 'json',
            success: function (res) {
                let msgText = res.data && res.data.message ? res.data.message : 'A apărut o eroare.';
                let bgColor = res.success ? '#d1e7dd' : '#f8d7da';
                let textColor = res.success ? '#0f5132' : '#842029';
                let borderColor = res.success ? '#badbcc' : '#f5c2c7';
                
                let $msg = $('<div class="gart-form-message"></div>').text(msgText).css({
                    'background-color': bgColor,
                    'color': textColor,
                    'border': '1px solid ' + borderColor,
                    'padding': '12px 16px',
                    'margin-bottom': '16px',
                    'border-radius': '6px',
                    'font-size': '14px',
                    'font-weight': '500',
                    'display': 'none'
                });
                
                $form.before($msg);
                $msg.fadeIn(300);
                
                if (res.success) {
                    $btn.text('Succes!');
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else {
                    $btn.prop('disabled', false).text(originalBtnText);
                }
            },
            error: function () {
                let $msg = $('<div class="gart-form-message"></div>').text('O eroare a apărut la procesarea solicitării.').css({
                    'background-color': '#f8d7da',
                    'color': '#842029',
                    'border': '1px solid #f5c2c7',
                    'padding': '12px 16px',
                    'margin-bottom': '16px',
                    'border-radius': '6px',
                    'font-size': '14px',
                    'font-weight': '500',
                    'display': 'none'
                });
                
                $form.before($msg);
                $msg.fadeIn(300);
                $btn.prop('disabled', false).text(originalBtnText);
            }
        });
    });

    // Close modal
    $(document).on('click', '.close-modal, #login-register-modal', function (e) {
        if (e.target === this) {
            $('#login-register-modal').removeClass('active');
            $backdrop.removeClass('is-visible');
        }
    });

    $backdrop.on('click', function () {
        $('#login-register-modal').removeClass('active');
    });

    // ==================== DRAWER ====================
    const $toggle = $('#drawer-toggle');
    const $drawer = $('.drawer');
    const $close = $('.drawer_close');
    const $body = $('body');

    // Open drawer
    $toggle.on('click', function (e) {
        e.preventDefault();
        openDrawer();
    });

    // Close events
    $close.on('click', closeDrawer);
    $backdrop.on('click', closeDrawer);

    // Close with Escape key
    $(document).on('keydown', function (e) {
        if (e.key === 'Escape' && $drawer.hasClass('is-open')) {
            closeDrawer();
        }
    });

    // Close menu links after click (with small delay)
    $drawer.find('a').on('click', function () {
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

    $(window).on('scroll', function () {
        if ($(window).scrollTop() > 100) {
            $('.header').addClass('sticky');
        } else {
            $('.header').removeClass('sticky');
        }
    });

});