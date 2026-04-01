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

    /* =========================================
     * WOOCOMMERCE AJAX FILTERS & LOAD MORE
     * ========================================= */

    if ($('.shop-container').length) {
        let $pag = $('.woocommerce-pagination');
        if ($pag.length) {
            let hasNext = $pag.find('a.next').length > 0;
            $pag.hide();
            if (hasNext) {
                $pag.after('<div class="gart-load-more-container"><button class="btn gart-load-more" data-page="2">Încarcă mai multe <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 transition-transform"><path d="m6 9 6 6 6-6"></path></svg></button></div>');
            }
        }
    }

    function ajaxFilterProducts(page = 1, isLoadMore = false) {
        let $rightProducts = $('.right_products');
        let $loadMoreBtn = $('.gart-load-more');
        
        // Grab values directly
        let checkedCats = $('.left_filters input[name="cat"]:checked').map(function() { return this.value; }).get().join(',');
        let checkedSizes = $('.left_filters input[name="pa_marime"]:checked').map(function() { return this.value; }).get().join(',');
        let checkedColors = $('.left_filters input[name="pa_culoare"]:checked').map(function() { return this.value; }).get().join(',');
        let orderby = $('.woocommerce-ordering select').val() || '';

        // UI Loading
        if (!isLoadMore && $rightProducts.length) {
            $rightProducts.css('position', 'relative').append('<div class="gart-ajax-overlay" style="position:absolute;top:0;left:0;width:100%;height:100%;background:rgba(255,255,255,0.7);z-index:999;"><div style="width:40px;height:40px;border:4px solid #eaeaea;border-top:4px solid #000;border-radius:50%;animation:gart-spin 1s linear infinite;margin:100px auto;"></div></div>');
            if (!$('#gart-spin-css').length) $('head').append('<style id="gart-spin-css">@keyframes gart-spin{to{transform:rotate(360deg)}}</style>');
        } else if (isLoadMore) {
            $loadMoreBtn.text('Se încarcă...').prop('disabled', true);
        }

        $.ajax({
            url: gart_ajax.url,
            type: 'POST',
            data: {
                action: 'gart_filter_products',
                security: gart_ajax.nonce,
                product_cat: checkedCats,
                pa_marime: checkedSizes,
                pa_culoare: checkedColors,
                orderby: orderby,
                paged: page,
                is_load_more: isLoadMore ? 'true' : 'false'
            },
            success: function(response) {
                if (!response.success) return;
                
                let html = response.data.html;
                let hasNext = response.data.has_next;

                if (isLoadMore) {
                    if (html.trim() !== '') {
                        $('ul.products').length ? $('ul.products').append(html) : $('.products').append(html);
                    }
                    
                    if (hasNext) {
                        $loadMoreBtn.attr('data-page', page + 1).text('Încarcă mai multe').prop('disabled', false);
                    } else {
                        $('.gart-load-more-container').remove();
                    }
                } else {
                    if (html.trim() !== '') {
                        $('.right_products').html('<div class="site-main"><div class="woocommerce-content">' + html + '</div></div>');
                    } else {
                        $('.right_products').html('<div class="woocommerce-info">Niciun produs găsit.</div>');
                    }
                    
                    $('.gart-load-more-container, .woocommerce-pagination').remove();
                    if (hasNext) {
                        $('.right_products .woocommerce-content').append('<div class="gart-load-more-container"><button class="btn gart-load-more" data-page="2">Încarcă mai multe <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 transition-transform"><path d="m6 9 6 6 6-6"></path></svg></button></div>');
                    }
                    
                    let offset = $('.shop-container').offset();
                    if (offset && $(window).scrollTop() > offset.top) {
                        $('html, body').animate({ scrollTop: offset.top - 50 }, 400);
                    }
                }
            }
        });
    }

    $(document).on('change', '.left_filters input[type="checkbox"]', function() {
        ajaxFilterProducts(1, false);
    });

    $(document).on('click', '.reset-filters', function(e) {
        e.preventDefault();
        $('.left_filters input[type="checkbox"]').prop('checked', false);
        ajaxFilterProducts(1, false);
    });

    $(document).on('click', '.gart-load-more', function(e) {
        e.preventDefault();
        let $btn = $(this);
        let page = parseInt($btn.attr('data-page'));
        
        if (!page) return;

        if ($btn.closest('.blog_posts').length) {
            $btn.text('Se încarcă...').prop('disabled', true);
            $.ajax({
                url: gart_ajax.url,
                type: 'POST',
                data: {
                    action: 'gart_load_more_posts',
                    paged: page,
                    security: gart_ajax.nonce
                },
                success: function(response) {
                    if (response.success) {
                        if (response.data.html.trim() !== '') {
                            $('.blog_posts .posts_grid').append(response.data.html);
                        }
                        if (response.data.has_next) {
                            $btn.attr('data-page', page + 1).html('Încarcă mai multe <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-chevron-down w-4 h-4 transition-transform"><path d="m6 9 6 6 6-6"></path></svg>').prop('disabled', false);
                        } else {
                            $btn.closest('.gart-load-more-container').remove();
                        }
                    } else {
                        $btn.text('Eroare').prop('disabled', false);
                    }
                },
                error: function() {
                    $btn.text('Eroare la încărcare').prop('disabled', false);
                }
            });
        } else {
            ajaxFilterProducts(page, true);
        }
    });

    $(document).on('change', '.woocommerce-ordering select', function() {
        ajaxFilterProducts(1, false);
    });

});