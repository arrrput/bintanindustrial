/**
 * Global feedback helpers.
 * - window.ButtonLoading.start / setText / stop: "Saving..." + disabled state on a button
 * - Every POST form submit puts its submit button into the loading state automatically
 *   (opt out with data-no-loading on the form or button, custom text with data-loading-text)
 * - window.AppAlert.success / error / warning / confirm (SweetAlert2)
 * - Flash messages from Laravel session (see partials/swal-flash.blade.php)
 * - <form data-confirm="Message?"> shows a confirm dialog before submitting
 */
(function () {
    "use strict";

    /* ---------------------------------------------------------------
     * Button loading state (does not depend on SweetAlert2)
     * ------------------------------------------------------------- */
    const originalContent = new WeakMap();

    const ButtonLoading = {
        start(btn, text = 'Saving...') {
            if (!btn || btn.dataset.loading === '1') return;
            btn.dataset.loading = '1';
            btn.setAttribute('aria-busy', 'true');

            if (btn.tagName === 'INPUT') {
                btn.dataset.originalValue = btn.value;
                btn.value = text;
            } else {
                const iconOnly = btn.textContent.trim() === '';
                btn.style.minWidth = btn.offsetWidth + 'px'; // keep the layout from jumping
                // Move the original nodes aside (not innerHTML) so references to elements
                // inside the button, e.g. a selection counter, stay valid after stop()
                const original = document.createDocumentFragment();
                while (btn.firstChild) original.appendChild(btn.firstChild);
                originalContent.set(btn, original);
                btn.innerHTML = iconOnly
                    ? '<span class="spinner-border spinner-border-sm" aria-hidden="true"></span>'
                    : '<span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span><span class="js-loading-text"></span>';
                const label = btn.querySelector('.js-loading-text');
                if (label) label.textContent = text;
            }
            btn.disabled = true;
        },
        setText(btn, text) {
            if (!btn || btn.dataset.loading !== '1') return;
            if (btn.tagName === 'INPUT') { btn.value = text; return; }
            const label = btn.querySelector('.js-loading-text');
            if (label) label.textContent = text;
        },
        stop(btn) {
            if (!btn || btn.dataset.loading !== '1') return;
            if (btn.tagName === 'INPUT') {
                btn.value = btn.dataset.originalValue || btn.value;
            } else {
                const original = originalContent.get(btn);
                if (original) {
                    btn.replaceChildren(original);
                    originalContent.delete(btn);
                }
                btn.style.minWidth = '';
            }
            delete btn.dataset.loading;
            delete btn.dataset.originalValue;
            btn.removeAttribute('aria-busy');
            btn.disabled = false;
        },
        // Loading text that fits the form: delete forms say "Deleting...", everything else "Saving..."
        textFor(form, btn) {
            if (btn && btn.dataset.loadingText) return btn.dataset.loadingText;
            if (form && form.dataset.loadingText) return form.dataset.loadingText;
            const spoofed = form && form.querySelector('input[name="_method"]');
            return spoofed && spoofed.value.toUpperCase() === 'DELETE' ? 'Deleting...' : 'Saving...';
        },
        submitButtonOf(form, submitter) {
            if (submitter) return submitter;
            return form.querySelector('button[type="submit"], input[type="submit"], button:not([type])')
                || (form.id ? document.querySelector(`[form="${form.id}"][type="submit"]`) : null);
        },
    };

    window.ButtonLoading = ButtonLoading;

    // Regular (non-AJAX) POST forms: show the loading state once the browser actually submits.
    // Runs in the bubble phase, so forms whose own script calls preventDefault() (AJAX) are skipped.
    document.addEventListener('submit', function (event) {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || event.defaultPrevented) return;
        if ((form.getAttribute('method') || 'get').toLowerCase() !== 'post') return;
        if ('noLoading' in form.dataset) return;

        // Block double submits while the first one is still in flight
        if (form.dataset.submitting === '1') {
            event.preventDefault();
            return;
        }

        const btn = ButtonLoading.submitButtonOf(form, event.submitter);
        if (btn && 'noLoading' in btn.dataset) return;

        form.dataset.submitting = '1';
        // Defer so the clicked button's name/value is still included in the submitted data
        setTimeout(() => ButtonLoading.start(btn, ButtonLoading.textFor(form, btn)), 0);
    });

    // Back/forward cache: restore buttons if the user navigates back to this page
    window.addEventListener('pageshow', function (event) {
        if (!event.persisted) return;
        document.querySelectorAll('[data-loading="1"]').forEach(btn => ButtonLoading.stop(btn));
        document.querySelectorAll('form[data-submitting="1"]').forEach(form => { delete form.dataset.submitting; });
        document.querySelectorAll('form[data-confirmed="1"]').forEach(form => { delete form.dataset.confirmed; });
    });

    /* ---------------------------------------------------------------
     * SweetAlert2 alerts
     * ------------------------------------------------------------- */
    if (typeof Swal === 'undefined') return;

    const PENDING_KEY = 'appAlert.pendingSuccess';

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3500,
        timerProgressBar: true,
        didOpen: (el) => {
            el.addEventListener('mouseenter', Swal.stopTimer);
            el.addEventListener('mouseleave', Swal.resumeTimer);
        },
    });

    const AppAlert = {
        success(text, title = 'Success') {
            return Toast.fire({ icon: 'success', titleText: text || title });
        },
        info(text) {
            return Toast.fire({ icon: 'info', titleText: text });
        },
        error(text, title = 'Failed') {
            return Swal.fire({ icon: 'error', title, html: text, confirmButtonColor: '#335642' });
        },
        warning(text, title = 'Attention') {
            return Swal.fire({ icon: 'warning', title, html: text, confirmButtonColor: '#335642' });
        },
        async confirm(text, opts = {}) {
            const res = await Swal.fire({
                title: opts.title || 'Are you sure?',
                text,
                icon: opts.icon || 'warning',
                showCancelButton: true,
                confirmButtonText: opts.confirmText || 'Yes, delete',
                cancelButtonText: opts.cancelText || 'Cancel',
                confirmButtonColor: opts.confirmColor || '#d33',
                cancelButtonColor: '#6c757d',
                reverseButtons: true,
                focusCancel: true,
            });
            return res.isConfirmed;
        },
        // For AJAX saves that navigate afterwards: the success toast is shown on the next page
        successAfterRedirect(text) {
            try { sessionStorage.setItem(PENDING_KEY, text); } catch (e) {}
        },
    };

    window.AppAlert = AppAlert;

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Success message carried over from an AJAX save + redirect
        let pending = null;
        try {
            pending = sessionStorage.getItem(PENDING_KEY);
            sessionStorage.removeItem(PENDING_KEY);
        } catch (e) {}
        if (pending) AppAlert.success(pending);

        // Laravel flash messages
        const el = document.getElementById('swal-flash-data');
        if (!el) return;

        let flash = {};
        try { flash = JSON.parse(el.textContent || '{}'); } catch (e) { return; }

        if (flash.errors && flash.errors.length) {
            const html = flash.errors.length === 1
                ? escapeHtml(flash.errors[0])
                : '<ul class="text-start mb-0">' + flash.errors.map(e => `<li>${escapeHtml(e)}</li>`).join('') + '</ul>';
            AppAlert.error(html, flash.error ? escapeHtml(flash.error) : 'Please check your input');
        } else if (flash.error) {
            AppAlert.error(escapeHtml(flash.error));
        } else if (flash.warning) {
            AppAlert.warning(escapeHtml(flash.warning));
        } else if (flash.success) {
            AppAlert.success(flash.success);
        } else if (flash.info) {
            AppAlert.info(flash.info);
        }
    });

    // <form data-confirm="..."> delete/submit confirmation
    document.addEventListener('submit', async function (event) {
        const form = event.target;
        if (!(form instanceof HTMLFormElement) || !form.dataset.confirm) return;
        if (form.dataset.confirmed === '1') return;

        event.preventDefault();
        const ok = await AppAlert.confirm(form.dataset.confirm, {
            title: form.dataset.confirmTitle,
            confirmText: form.dataset.confirmButton,
        });
        if (!ok) return;

        form.dataset.confirmed = '1';
        if (typeof form.requestSubmit === 'function') {
            form.requestSubmit(event.submitter || undefined);
        } else {
            form.submit();
        }
    }, true);
})();
