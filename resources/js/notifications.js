/**
 * notifications.js  v2.0
 * Real-time notification handler — Admin Dashboard & Front-end.
 *
 * Requirements:
 *   - Laravel Echo + Pusher/Reverb initialised on window.Echo
 *   - In your Blade layout, BEFORE this script:
 *
 *   Admin layout:
 *       <script>
 *           window.APP_ROLE    = "admin";
 *           window._authUserId = "{{ auth()->id() }}";
 *       </script>
 *
 *   Front layout:
 *       <script>
 *           window.APP_ROLE    = "user";
 *           window._authUserId = "{{ auth()->id() }}";
 *       </script>
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ─────────────────────────────────────────────────────────────────────
       1. DETECT INTERFACE
       Primary:  window.APP_ROLE  (set in Blade layout — most reliable)
       Fallback: DOM fingerprint  (in case APP_ROLE was forgotten)
    ───────────────────────────────────────────────────────────────────── */
    const IS_ADMIN = window.APP_ROLE === 'admin'
        || (!window.APP_ROLE && !!document.getElementById('notif-bell-icon'));

    const IS_FRONT = window.APP_ROLE === 'user'
        || (!window.APP_ROLE && !!document.querySelector('.notif-wrapper'));

    console.log(
        '[Notifications] Interface:',
        IS_ADMIN ? 'Admin Dashboard' : IS_FRONT ? 'Front-end' : 'Unknown (Echo disabled)'
    );

    // Nothing to do on pages where neither panel is present (e.g. login page)
    if (!IS_ADMIN && !IS_FRONT) return;

    /* ─────────────────────────────────────────────────────────────────────
       2. CSRF TOKEN  (cached once, used everywhere)
    ───────────────────────────────────────────────────────────────────── */
    const CSRF = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

    /* ─────────────────────────────────────────────────────────────────────
       3. INJECT KEYFRAMES  (once per page)
    ───────────────────────────────────────────────────────────────────── */
    if (!document.getElementById('notif-toast-style')) {
        const s = document.createElement('style');
        s.id = 'notif-toast-style';
        s.textContent = `
            @keyframes notifSlideIn { from { transform:translateX(110%); opacity:0 } to { transform:none; opacity:1 } }
            @keyframes notifFadeOut { to   { opacity:0; transform:translateX(110%) } }
        `;
        document.head.appendChild(s);
    }

    /* ─────────────────────────────────────────────────────────────────────
       4. INITIALISE ECHO  (with retry, max 2 s)
    ───────────────────────────────────────────────────────────────────── */
    function initEcho() {
        const userId = window._authUserId;
        if (!userId) {
            console.warn('[Notifications] window._authUserId is not set.');
            return;
        }

        window.Echo
            .private(`App.Models.User.${userId}`)
            .notification((notification) => {
                if (IS_ADMIN) {
                    incrementAdminBadge();
                    prependAdminItem(notification);
                }
                if (IS_FRONT) {
                    incrementFrontBadge();
                    prependFrontItem(notification);
                }
                showToast(notification);
            });
    }

    if (window.Echo) {
        initEcho();
    } else {
        let tries = 0;
        const interval = setInterval(() => {
            if (window.Echo) {
                clearInterval(interval);
                initEcho();
            } else if (++tries > 20) {           // give up after 2 s
                clearInterval(interval);
                console.warn('[Notifications] Laravel Echo not found after 2 s.');
            }
        }, 100);
    }

    /* ═════════════════════════════════════════════════════════════════════
       ADMIN  ─  Badge & Dropdown
    ═════════════════════════════════════════════════════════════════════ */

    function incrementAdminBadge() {
        let badge = document.getElementById('notif-badge');

        if (!badge) {
            const parent = document.getElementById('notif-bell-icon')?.closest('.nav-link');
            if (!parent) return;

            badge = document.createElement('span');
            badge.id        = 'notif-badge';
            badge.className = 'badge badge-danger badge-pill position-absolute';
            badge.style.cssText = [
                'position:absolute', 'top:2px', 'right:2px',
                'background:#dc3545', 'color:#fff', 'border-radius:50%',
                'font-size:11px', 'font-weight:bold',
                'min-width:16px', 'height:16px', 'line-height:16px',
                'padding:0 4px', 'text-align:center', 'box-shadow:0 0 0 2px #fff',
            ].join(';');
            badge.textContent = '1';
            parent.style.position = 'relative';
            parent.appendChild(badge);
            return;
        }

        const current = parseInt(badge.textContent) || 0;
        badge.textContent   = current + 1 > 99 ? '99+' : current + 1;
        badge.style.display = 'inline-block';
    }

    function prependAdminItem(n) {
        const list = document.getElementById('notif-list');
        if (!list) return;

        list.querySelector('.notif-empty')?.remove();

        // Cap list at 8 items so the dropdown doesn't grow forever
        const existing = list.querySelectorAll('.notif-item');
        if (existing.length >= 8) existing[existing.length - 1].remove();

        const color = n.color || 'primary';
        const icon  = n.icon  || 'fe-bell';

const item = document.createElement('a');

item.href = n.url || '#';
item.className = 'd-flex align-items-start px-3 py-2 border-bottom bg-soft-primary notif-item';
item.style.textDecoration = 'none';
        item.innerHTML = `
            <div class="mr-2 mt-1">
                <span class="fe ${escHtml(icon)} text-${escHtml(color)}" style="font-size:1rem;"></span>
            </div>
            <div class="flex-grow-1" style="min-width:0;">
                <div class="d-flex justify-content-between align-items-start">
                    <strong class="small text-dark">${escHtml(n.title || 'Notification')}</strong>
                    <span class="badge badge-${escHtml(color)} ml-1" style="font-size:.5rem;">New</span>
                </div>
                <p class="small text-muted mb-0 text-truncate" style="font-size:.75rem;">${escHtml(n.message || '')}</p>
                <small class="text-muted" style="font-size:.7rem;">Just now</small>
            </div>
        `;
        list.prepend(item);

        _incrementPillCount('.badge-primary');
    }

    /* ═════════════════════════════════════════════════════════════════════
       FRONT-END  ─  Badge & Dropdown
    ═════════════════════════════════════════════════════════════════════ */

    function incrementFrontBadge() {
        let badge = document.querySelector('.notif-wrapper .notif-badge');

        if (!badge) {
            const btn = document.querySelector('.notif-btn');
            if (!btn) return;

            badge = document.createElement('span');
            badge.className   = 'notif-badge';
            badge.textContent = '1';
            btn.appendChild(badge);
            return;
        }

        const current = parseInt(badge.textContent) || 0;
        badge.textContent = current + 1 > 9 ? '9+' : current + 1;
    }

    function prependFrontItem(n) {
        const list = document.querySelector('.notif-list');
        if (!list) return;

        list.querySelector('.notif-empty')?.remove();

        // Cap list at 4 items (matches the Blade take(4))
        const existing = list.querySelectorAll('form');
        if (existing.length >= 4) existing[existing.length - 1].remove();

        const statusIconMap = {
            confirmed : ['fa-circle-check',   '#16a34a', '#dcfce7'],
            cancelled : ['fa-circle-xmark',   '#dc2626', '#fee2e2'],
            completed : ['fa-flag-checkered', '#006aff', '#eff4ff'],
            pending   : ['fa-clock',          '#d97706', '#fef3c7'],
        };

        const status = n.status || 'pending';
        const [ico, clr, bg] = statusIconMap[status] ?? ['fa-calendar-check', '#006aff', '#eff4ff'];

        if (!CSRF) {
            console.warn('[Notifications] CSRF token meta tag missing.');
            return;
        }

        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/notifications/${escHtml(String(n.id))}/mark-as-read`;
        form.style.display = 'block';

        form.innerHTML = `
            <input type="hidden" name="_token" value="${CSRF}">
            <button type="submit" class="notif-item notif-unread"
                    style="width:100%;border:none;background:none;text-align:left;
                           display:flex;align-items:center;padding:12px 15px;cursor:pointer;">

                <div class="notif-ico-wrap"
                     style="background:${bg};width:40px;height:40px;border-radius:10px;
                            display:flex;align-items:center;justify-content:center;
                            flex-shrink:0;margin-right:12px;">
                    <i class="fa-solid ${escHtml(ico)}" style="color:${clr};font-size:17px;"></i>
                </div>

                <div class="notif-body" style="flex-grow:1;min-width:0;">
                    <p class="notif-text"
                       style="margin:0;font-size:0.9rem;color:#334155;line-height:1.4;white-space:normal;">
                        ${escHtml(n.message || '')}
                    </p>
                    <span class="notif-time" style="font-size:0.75rem;color:#94a3b8;">Just now</span>
                </div>

                <span class="notif-dot"
                      style="width:8px;height:8px;background:#006aff;border-radius:50%;
                             margin-left:10px;flex-shrink:0;"></span>
            </button>
        `;

        list.prepend(form);

        _incrementPillCount('.notif-count-pill');
    }

    /* ═════════════════════════════════════════════════════════════════════
       SHARED  ─  Toast
    ═════════════════════════════════════════════════════════════════════ */

    function showToast(n) {
        let container = document.getElementById('notif-toast-container');
        if (!container) {
            container    = document.createElement('div');
            container.id = 'notif-toast-container';
            Object.assign(container.style, {
                position       : 'fixed',
                bottom         : '20px',
                right          : '20px',
                zIndex         : '9999',
                display        : 'flex',
                flexDirection  : 'column',
                gap            : '8px',
                pointerEvents  : 'none',   // let clicks pass through the gap
            });
            document.body.appendChild(container);
        }

        const colorMap = {
            primary : '#1b68ff', success : '#28a745',
            info    : '#17a2b8', warning : '#ffc107', danger : '#dc3545',
        };
        const borderColor = IS_FRONT
            ? (n.color || '#1b68ff')
            : (colorMap[n.color] || '#1b68ff');

        const iconHtml = IS_ADMIN
            ? `<span class="fe ${escHtml(n.icon || 'fe-bell')}"
                     style="color:${borderColor};font-size:1.1rem;margin-top:2px;flex-shrink:0;"></span>`
            : `<i class="fa-solid ${escHtml(n.icon || 'fa-bell')}"
                  style="color:${borderColor};font-size:1.1rem;margin-top:2px;flex-shrink:0;"></i>`;

        const toast = document.createElement('div');
        toast.style.cssText = [
            'background:#fff',
            `border-left:4px solid ${borderColor}`,
            'border-radius:6px',
            'box-shadow:0 4px 16px rgba(0,0,0,.14)',
            'padding:12px 16px',
            'min-width:280px',
            'max-width:340px',
            'display:flex',
            'align-items:flex-start',
            'gap:10px',
            'animation:notifSlideIn .3s ease',
            'pointer-events:all',          // re-enable for the toast itself
        ].join(';');

        toast.innerHTML = `
            ${iconHtml}
            <div style="flex:1;min-width:0;">
                <strong style="font-size:.85rem;display:block;">${escHtml(n.title || '')}</strong>
                <span style="font-size:.8rem;color:#6c757d;">${escHtml(n.message || '')}</span>
            </div>
            <button class="notif-toast-close"
                    style="background:none;border:none;cursor:pointer;color:#aaa;
                           font-size:1.1rem;line-height:1;padding:0;flex-shrink:0;">×</button>
        `;

        // ✅ Safe close — no fragile .closest('div[style]')
        toast.querySelector('.notif-toast-close').addEventListener('click', () => removeToast(toast));

        container.appendChild(toast);

        // ✅ Pause auto-dismiss on hover
        let timer = startDismissTimer(toast);
        toast.addEventListener('mouseenter', () => clearTimeout(timer));
        toast.addEventListener('mouseleave', () => { timer = startDismissTimer(toast); });
    }

    function startDismissTimer(toast) {
        return setTimeout(() => removeToast(toast), 5000);
    }

    function removeToast(toast) {
        if (!toast.isConnected) return;
        toast.style.animation = 'notifFadeOut .3s ease forwards';
        setTimeout(() => toast.remove(), 320);
    }

    /* ─────────────────────────────────────────────────────────────────────
       HELPERS
    ───────────────────────────────────────────────────────────────────── */

    /** Increment any small pill counter identified by a CSS selector */
    function _incrementPillCount(selector) {
        const pill = document.querySelector(selector);
        if (!pill) return;
        const current = parseInt(pill.textContent) || 0;
        pill.textContent   = current + 1;
        pill.style.display = 'inline-block';
    }

    /** Basic XSS guard for values injected into innerHTML */
    function escHtml(str) {
        return String(str)
            .replace(/&/g,  '&amp;')
            .replace(/</g,  '&lt;')
            .replace(/>/g,  '&gt;')
            .replace(/"/g,  '&quot;')
            .replace(/'/g,  '&#39;');
    }

});