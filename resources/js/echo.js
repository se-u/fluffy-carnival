import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

const reverbHost = import.meta.env.VITE_REVERB_HOST;
const reverbPort = import.meta.env.VITE_REVERB_PORT;
const reverbScheme = import.meta.env.VITE_REVERB_SCHEME ?? 'http';

console.log('[ECHO] VITE_REVERB_HOST:', reverbHost);
console.log('[ECHO] VITE_REVERB_PORT:', reverbPort);
console.log('[ECHO] VITE_REVERB_SCHEME:', reverbScheme);
console.log('[ECHO] VITE_REVERB_APP_KEY:', import.meta.env.VITE_REVERB_APP_KEY);

try {
    window.Echo = new Echo({
        broadcaster: 'reverb',
        key: import.meta.env.VITE_REVERB_APP_KEY,
        wsHost: reverbHost,
        wsPort: reverbPort,
        forceTLS: false,
        enabledTransports: ['ws'],
    });
    console.log('[ECHO] Window.Echo created successfully:', !!window.Echo);
    console.log('[ECHO] Echo connector:', window.Echo.connector);
} catch (error) {
    console.error('[ECHO] Error creating Echo:', error);
}
