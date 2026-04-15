
// document.addEventListener('DOMContentLoaded', () => {
 
//     const userId = window._authUserId;
//     if (!userId || !window.Echo) return;
 
//     // ─── Listen على private channel بتاع اليوزر الحالي فقط ──
//     window.Echo
//         .private(`App.Models.User.${userId}`)
//         .notification((notification) => {
//             updateBadge();
//             prependToDropdown(notification);
//             showToast(notification);
//         });
 
//     // ─── +1 على الـ badge ────────────────────────
//     function updateBadge() {
//         let badge = document.getElementById('notif-badge');
 
//         if (!badge) {
//             badge = document.createElement('span');
//             badge.id = 'notif-badge';
//             badge.className = 'badge badge-danger badge-pill position-absolute';
//             badge.style.cssText = 'top:4px;right:4px;font-size:.6rem;min-width:16px;height:16px;line-height:16px;padding:0 4px;';
//             badge.textContent = '1';
//             document.querySelector('#notif-bell-icon')?.closest('.nav-link')?.appendChild(badge);
//             return;
//         }
 
//         const current = parseInt(badge.textContent) || 0;
//         badge.textContent = current + 1 > 99 ? '99+' : current + 1;
//     }
 
//     // ─── أضف الـ notification في أول الـ dropdown ──
//     function prependToDropdown(n) {
//         const list = document.getElementById('notif-list');
//         if (!list) return;
 
//         // شيل الـ empty state
//         list.querySelector('.notif-empty')?.remove();
 
//         const color = n.color || 'primary';
//         const icon  = n.icon  || 'fe-bell';
 
//         const item = document.createElement('div');
//         item.className = 'd-flex align-items-start px-3 py-2 border-bottom bg-soft-primary notif-item';
//         item.innerHTML = `
//             <div class="mr-3 mt-1">
//                 <span class="fe ${icon} text-${color}" style="font-size:1.1rem;"></span>
//             </div>
//             <div class="flex-grow-1" style="min-width:0;">
//                 <div class="d-flex justify-content-between align-items-start">
//                     <strong class="small text-dark">${n.title || 'Notification'}</strong>
//                     <span class="badge badge-${color} ml-1" style="font-size:.55rem;">New</span>
//                 </div>
//                 <p class="small text-muted mb-1 text-truncate">${n.message || ''}</p>
//                 <small class="text-muted">Just now</small>
//             </div>
//         `;
//         list.prepend(item);
//     }
 
//     // ─── Toast في الركن ──────────────────────────
//     function showToast(n) {
//         let container = document.getElementById('toast-container');
//         if (!container) {
//             container = document.createElement('div');
//             container.id = 'toast-container';
//             container.style.cssText = 'position:fixed;bottom:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;';
//             document.body.appendChild(container);
//         }
 
//         const colorMap = {
//             primary: '#1b68ff', success: '#28a745',
//             info:    '#17a2b8', warning: '#ffc107', danger: '#dc3545',
//         };
//         const borderColor = colorMap[n.color] || '#1b68ff';
 
//         const toast = document.createElement('div');
//         toast.style.cssText = `
//             background:#fff;border-left:4px solid ${borderColor};border-radius:6px;
//             box-shadow:0 4px 16px rgba(0,0,0,.12);padding:12px 16px;
//             min-width:280px;max-width:340px;
//             display:flex;align-items:flex-start;gap:10px;
//             animation:slideInRight .3s ease;
//         `;
//         toast.innerHTML = `
//             <span class="fe ${n.icon || 'fe-bell'}" style="color:${borderColor};font-size:1.1rem;margin-top:2px;"></span>
//             <div style="flex:1;">
//                 <strong style="font-size:.85rem;display:block;">${n.title || ''}</strong>
//                 <span style="font-size:.8rem;color:#6c757d;">${n.message || ''}</span>
//             </div>
//             <button onclick="this.closest('[style]').remove()"
//                     style="background:none;border:none;cursor:pointer;color:#aaa;font-size:1rem;line-height:1;padding:0;">×</button>
//         `;
 
//         container.appendChild(toast);
//         setTimeout(() => {
//             toast.style.animation = 'fadeOut .3s ease forwards';
//             setTimeout(() => toast.remove(), 300);
//         }, 5000);
//     }
 
// });

/**
 * notifications.js
 * Real-time notification handler — works on both Admin Dashboard & Front-end.
 * Requires: Laravel Echo + Pusher (or Reverb) already initialised on window.Echo
 *           window._authUserId set before this script runs
 */

document.addEventListener('DOMContentLoaded', () => {

    /* ─── Detect which interface we're on ─────────────────────────────────── */
    const IS_ADMIN = !!document.getElementById('notif-bell-icon');   // admin navbar
    const IS_FRONT = !!document.querySelector('.notif-wrapper');      // front navbar

    function init() {
        const userId = window._authUserId;
        if (!userId || !window.Echo) return;

        /* ─── Listen on private channel ───────────────────────────────────────── */
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

    // لو Echo موجود على طول ابدأ، لو لا استنى
    if (window.Echo) {
        init();
    } else {
        let tries = 0;
        const interval = setInterval(() => {
            tries++;
            if (window.Echo) {
                clearInterval(interval);
                init();
            } else if (tries > 20) { // استنى max 2 ثانية
                clearInterval(interval);
            }
        }, 100);
    }

    /* ══════════════════════════════════════════════════════════════════════
       ADMIN DASHBOARD
    ══════════════════════════════════════════════════════════════════════ */

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
                'padding:0 4px', 'text-align:center', 'box-shadow:0 0 0 1px #fff',
            ].join(';');
            badge.textContent = '1';
            parent.style.position = 'relative';
            parent.appendChild(badge);
            return;
        }

        const n = parseInt(badge.textContent) || 0;
        badge.textContent    = n + 1 > 99 ? '99+' : n + 1;
        badge.style.display  = 'inline-block';
    }

    function prependAdminItem(n) {
        const list = document.getElementById('notif-list');
        if (!list) return;

        // Remove empty-state placeholder if present
        list.querySelector('.notif-empty')?.remove();

        const color = n.color || 'primary';
        const icon  = n.icon  || 'fe-bell';

        const item = document.createElement('div');
        item.className = 'd-flex align-items-start px-3 py-2 border-bottom bg-soft-primary notif-item';
        item.innerHTML = `
            <div class="mr-2 mt-1">
                <span class="fe ${icon} text-${color}" style="font-size:1rem;"></span>
            </div>
            <div class="flex-grow-1" style="min-width:0;">
                <div class="d-flex justify-content-between align-items-start">
                    <strong class="small text-dark">${n.title || 'Notification'}</strong>
                    <span class="badge badge-${color} ml-1" style="font-size:.5rem;">New</span>
                </div>
                <p class="small text-muted mb-0 text-truncate" style="font-size:.75rem;">${n.message || ''}</p>
                <small class="text-muted" style="font-size:.7rem;">Just now</small>
            </div>
        `;
        list.prepend(item);

        // Keep the in-header unread counter in sync
        _incrementPillCount('.badge-primary');
    }

    /* ══════════════════════════════════════════════════════════════════════
       FRONT-END (user interface)
    ══════════════════════════════════════════════════════════════════════ */

    function incrementFrontBadge() {
        let badge = document.querySelector('.notif-wrapper .notif-badge');

        if (!badge) {
            const btn = document.querySelector('.notif-btn');
            if (!btn) return;

            badge           = document.createElement('span');
            badge.className = 'notif-badge';
            badge.textContent = '1';
            btn.appendChild(badge);
            return;
        }

        const n = parseInt(badge.textContent) || 0;
        badge.textContent = n + 1 > 9 ? '9+' : n + 1;
    }

    function prependFrontItem(n) {
        const list = document.querySelector('.notif-list');
        if (!list) return;

        // Remove empty-state placeholder if present
        list.querySelector('.notif-empty')?.remove();

        const statusIconMap = {
            confirmed : ['fa-circle-check',   '#16a34a', '#dcfce7'],
            cancelled : ['fa-circle-xmark',   '#dc2626', '#fee2e2'],
            completed : ['fa-flag-checkered', '#006aff', '#eff4ff'],
            pending   : ['fa-clock',          '#d97706', '#fef3c7'],
        };
        const status = n.status || 'pending';
        const [ico, clr, bg] = statusIconMap[status] ?? ['fa-calendar-check', '#006aff', '#eff4ff'];

        const item = document.createElement('a');
        item.href      = '#';
        item.className = 'notif-item notif-unread';
        item.innerHTML = `
            <div class="notif-ico-wrap" style="background:${bg};">
                <i class="fa-solid ${ico}" style="color:${clr};font-size:17px;"></i>
            </div>
            <div class="notif-body">
                <p class="notif-text">${n.message || ''}</p>
                <span class="notif-time">Just now</span>
            </div>
            <span class="notif-dot"></span>
        `;
        list.prepend(item);

        // Keep in-header pill in sync
        _incrementPillCount('.notif-count-pill');
    }

    /* ══════════════════════════════════════════════════════════════════════
       SHARED TOAST
    ══════════════════════════════════════════════════════════════════════ */

    function showToast(n) {
        let container = document.getElementById('notif-toast-container');
        if (!container) {
            container    = document.createElement('div');
            container.id = 'notif-toast-container';
            container.style.cssText = [
                'position:fixed', 'bottom:20px', 'right:20px', 'z-index:9999',
                'display:flex', 'flex-direction:column', 'gap:8px',
            ].join(';');
            document.body.appendChild(container);
        }

        // Pick a border colour: admin uses n.color class name, front uses hex directly
        const colorMap = {
            primary : '#1b68ff', success : '#28a745',
            info    : '#17a2b8', warning : '#ffc107', danger : '#dc3545',
        };
        const borderColor = IS_FRONT
            ? (n.color || '#1b68ff')                    // front sends hex
            : (colorMap[n.color] || '#1b68ff');          // admin sends class name

        // Resolve icon — admin: Feather class string, front: FA class string
        const iconHtml = IS_ADMIN
            ? `<span class="fe ${n.icon || 'fe-bell'}" style="color:${borderColor};font-size:1.1rem;margin-top:2px;flex-shrink:0;"></span>`
            : `<i class="fa-solid ${n.icon || 'fa-bell'}" style="color:${borderColor};font-size:1.1rem;margin-top:2px;flex-shrink:0;"></i>`;

        const toast = document.createElement('div');
        toast.style.cssText = [
            `background:#fff`, `border-left:4px solid ${borderColor}`, `border-radius:6px`,
            `box-shadow:0 4px 16px rgba(0,0,0,.12)`, `padding:12px 16px`,
            `min-width:280px`, `max-width:340px`,
            `display:flex`, `align-items:flex-start`, `gap:10px`,
            `animation:notifSlideIn .3s ease`,
        ].join(';');
        toast.innerHTML = `
            ${iconHtml}
            <div style="flex:1;min-width:0;">
                <strong style="font-size:.85rem;display:block;">${n.title || ''}</strong>
                <span style="font-size:.8rem;color:#6c757d;">${n.message || ''}</span>
            </div>
            <button onclick="this.closest('div[style]').remove()"
                    style="background:none;border:none;cursor:pointer;color:#aaa;font-size:1rem;line-height:1;padding:0;flex-shrink:0;">×</button>
        `;

        // Add keyframe once
        if (!document.getElementById('notif-toast-style')) {
            const s = document.createElement('style');
            s.id = 'notif-toast-style';
            s.textContent = `
                @keyframes notifSlideIn  { from{transform:translateX(110%);opacity:0} to{transform:none;opacity:1} }
                @keyframes notifFadeOut  { to{opacity:0;transform:translateX(110%)} }
            `;
            document.head.appendChild(s);
        }

        container.appendChild(toast);
        setTimeout(() => {
            toast.style.animation = 'notifFadeOut .3s ease forwards';
            setTimeout(() => toast.remove(), 320);
        }, 5000);
    }

    /* ─── Helper: increment any small pill counter by selector ────────────── */
    function _incrementPillCount(selector) {
        const pill = document.querySelector(selector);
        if (!pill) return;
        const n = parseInt(pill.textContent) || 0;
        pill.textContent   = n + 1;
        pill.style.display = 'inline-block';
    }

});