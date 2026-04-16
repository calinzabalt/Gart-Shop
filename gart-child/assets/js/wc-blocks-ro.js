(function () {
    if (typeof wp === 'undefined' || !wp.hooks) return;

    const map = {
        'Products in cart':              'Produse în coș',
        'Cart':                          'Coș',
        'Cart totals':                   'Total coș',
        'Order summary':                 'Rezumat comandă',
        'Product':                       'Produs',
        'Total':                         'Total',
        'Price':                         'Preț',
        'Quantity':                      'Cantitate',
        'Subtotal':                      'Subtotal',
        'Add coupons':                   'Adaugă cupon',
        'Add a coupon':                  'Adaugă un cupon',
        'Coupon code':                   'Cod cupon',
        'Coupon Code':                   'Cod cupon',
        'Apply':                         'Aplică',
        'Remove coupon':                 'Șterge cuponul',
        'Estimated total':               'Total estimat',
        'Estimated taxes':               'TVA estimat',
        'Shipping':                      'Livrare',
        'Shipping options':              'Opțiuni de livrare',
        'Free':                          'Gratuit',
        'Flat rate':                     'Tarif fix',
        'Free shipping':                 'Livrare gratuită',
        'Calculated at checkout':        'Calculat la finalizare',
        'No shipping options available': 'Nicio opțiune de livrare disponibilă',
        'Enter address to calculate shipping': 'Introdu adresa pentru a calcula livrarea',
        'Proceed to Checkout':           'Finalizează comanda',
        'Return to Cart':                'Înapoi la coș',
        'Continue shopping':             'Continuă cumpărăturile',
        'Remove item':                   'Șterge',
        'Your cart is empty!':           'Coșul tău este gol!',
        'Start shopping':                'Începe cumpărăturile',
        'Checkout':                      'Finalizare comandă',
        'Contact information':           'Informații de contact',
        'Shipping address':              'Adresă de livrare',
        'Billing address':               'Adresă de facturare',
        'Use same address for billing':  'Folosește aceeași adresă pentru facturare',
        'Delivery':                      'Livrare',
        'Payment':                       'Plată',
        'Payment method':                'Metodă de plată',
        'Payment options':               'Opțiuni de plată',
        'Place Order':                   'Plasează comanda',
        'You are currently checking out as a guest.': 'Finalizezi comanda ca vizitator.',
        'First name':                    'Prenume',
        'Last name':                     'Nume',
        'Email address':                 'Adresă de email',
        'Email':                         'Email',
        'Phone':                         'Telefon',
        'Phone (optional)':              'Telefon (opțional)',
        'Company':                       'Companie',
        'Company (optional)':            'Companie (opțional)',
        'Address':                       'Adresă',
        'Street address':                'Stradă / Număr',
        '+ Add apartment, suite, etc.':              '+ Adaugă bloc, scară, apt.',
        'Add apartment, suite, etc.':                'Adaugă bloc, scară, apt.',
        'Apartment, suite, etc. (optional)':         'Bloc, scară, apt. (opțional)',
        'Apartment, suite, etc.':                    'Bloc, scară, apartament',
        'City':                          'Oraș',
        'Town / City':                   'Oraș',
        'County':                        'Județ',
        'State':                         'Județ',
        'State/County':                  'Județ',
        'State / County':                'Județ',
        'Postal code':                   'Cod poștal',
        'Zip / Postal code':             'Cod poștal',
        'Postcode / ZIP':                'Cod poștal',
        'Country/Region':                'Țară/Regiune',
        'Country / Region':              'Țară / Regiune',
        'Order notes':                   'Note comandă',
        'Add a note to your order':      'Adaugă o notă la comandă',
        'By proceeding with your purchase you agree to our <a1>Terms and Conditions</a1> and <a2>Privacy Policy</a2>':
            'Prin finalizarea comenzii ești de acord cu <a1>Termenii și Condițiile</a1> și <a2>Politica de Confidențialitate</a2>',
        'By proceeding with your purchase you agree to our Terms and Conditions and Privacy Policy':
            'Prin finalizarea comenzii ești de acord cu Termenii și Condițiile și Politica de Confidențialitate',
        'Terms and Conditions':          'Termeni și Condiții',
        'Privacy Policy':                'Politică de Confidențialitate',
        'Direct bank transfer':          'Transfer bancar',
        'Cash on delivery':              'Ramburs la livrare',
        'Credit / Debit Card':           'Card de credit / debit',
        'There are no payment methods available. Please contact us for help placing your order.':
            'Nu există metode de plată disponibile. Contactați-ne pentru asistență.',
        'Thank you for your order!':     'Îți mulțumim pentru comandă!',
        'Order received':                'Comandă primită',
        'Order number':                  'Număr comandă',
        'Date':                          'Dată',
        'Loading':                       'Se încarcă...',
        'required':                      'obligatoriu',
        'Edit':                          'Editează',
        'Save':                          'Salvează',
        'Cancel':                        'Anulează',
        'Close':                         'Închide',
    };

    function translate(translation, text) {
        return Object.prototype.hasOwnProperty.call(map, text) ? map[text] : translation;
    }

    const domains = ['woocommerce', 'woo-gutenberg-products-block'];
    domains.forEach(function (domain) {
        wp.hooks.addFilter('i18n.gettext_' + domain,              'gart/ro-' + domain, translate);
        wp.hooks.addFilter('i18n.gettext_with_context_' + domain, 'gart/ro-ctx-' + domain, translate);
    });

    const nmap = {
        '%d item':          { 1: '%d produs',           n: '%d produse' },
        '%d product':       { 1: '%d produs',           n: '%d produse' },
        '%d item removed.': { 1: '%d produs eliminat.', n: '%d produse eliminate.' },
    };
    function ntranslate(translation, single, plural, number) {
        if (Object.prototype.hasOwnProperty.call(nmap, single)) {
            return number === 1 ? nmap[single][1] : nmap[single].n;
        }
        return translation;
    }
    domains.forEach(function (domain) {
        wp.hooks.addFilter('i18n.ngettext_' + domain, 'gart/ro-n-' + domain, ntranslate);
    });

    const domMap = {
        'Country/Region':   'Țară/Regiune',
        'Address':          'Adresă',
        '+ Add apartment, suite, etc.': '+ Adaugă bloc, scară, apt.',
        'Add apartment, suite, etc.':   'Adaugă bloc, scară, apt.',
        'City':             'Oraș',
        'County':           'Județ',
        'Postal code':      'Cod poștal',
        'Phone (optional)': 'Telefon (opțional)',
        'By proceeding with your purchase you agree to our Terms and Conditions and Privacy Policy':
            'Prin finalizarea comenzii ești de acord cu Termenii și Condițiile și Politica de Confidențialitate',
    };

    const partialMap = [
        {
            replace: 'By proceeding with your purchase you agree to our',
            with:    'Prin finalizarea comenzii ești de acord cu',
        },
    ];

    function replaceTextNode(node) {
        const raw = node.textContent;
        const trimmed = raw.trim();

        if (trimmed && Object.prototype.hasOwnProperty.call(domMap, trimmed)) {
            node.textContent = raw.replace(trimmed, domMap[trimmed]);
            return;
        }

        for (let i = 0; i < partialMap.length; i++) {
            if (raw.includes(partialMap[i].replace)) {
                node.textContent = raw.replace(partialMap[i].replace, partialMap[i].with);
                return;
            }
        }
    }

    var privacyTimer = setInterval(function () {
        var span = document.querySelector('.wc-block-checkout__terms .wc-block-components-checkbox__label');
        if (!span) return;
        if (!span.textContent.includes(' and ')) { clearInterval(privacyTimer); return; }
        span.textContent = span.textContent.replace(' and ', ' și ');
        clearInterval(privacyTimer);
    }, 200);

    function walkAndReplace(root) {
        const walker = document.createTreeWalker(root, NodeFilter.SHOW_TEXT, null, false);
        let node;
        while ((node = walker.nextNode())) {
            replaceTextNode(node);
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        walkAndReplace(document.body);

        const observer = new MutationObserver(function (mutations) {
            mutations.forEach(function (m) {
                m.addedNodes.forEach(function (n) {
                    if (n.nodeType === 1) {
                        walkAndReplace(n);
                    } else if (n.nodeType === 3) {
                        replaceTextNode(n);
                    }
                });
            });
        });

        observer.observe(document.body, { childList: true, subtree: true });
    });

})();
