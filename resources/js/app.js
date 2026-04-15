// app.js — single source of truth
import './bootstrap';   // axios lives here (keep commented-out Echo in bootstrap.js)
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';
import Alpine from 'alpinejs';

window.Pusher = Pusher;
window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY,
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER,
    forceTLS: true,
    authEndpoint: '/broadcasting/auth',
    auth: {
        headers: {
            'X-CSRF-TOKEN': document
                .querySelector('meta[name="csrf-token"]')
                ?.getAttribute('content'),
        },
    },
});

window.Alpine = Alpine;
Alpine.start();

// Import notification listener AFTER Echo is ready
import './notifications';  // ← your DOMContentLoaded file