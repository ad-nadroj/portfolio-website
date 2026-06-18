import { defineConfig, loadEnv } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig(({ mode }) => {
    const env = loadEnv(mode, process.cwd(), '');
    const devServerPort = Number(env.VITE_DEV_SERVER_PORT || 5173);
    const appUrl = env.APP_URL || 'http://localhost:8083';

    let appOrigin = appUrl;
    let appHost = 'localhost';

    try {
        const parsedAppUrl = new URL(appUrl);

        appOrigin = parsedAppUrl.origin;
        appHost = parsedAppUrl.hostname;
    } catch {
        // Keep local defaults if APP_URL is invalid or incomplete.
    }

    const devServerHost = env.VITE_DEV_SERVER_HOST || appHost;
    const devServerOrigin = env.VITE_DEV_SERVER_ORIGIN || `http://${devServerHost}:${devServerPort}`;

    return {
        plugins: [
            laravel({
                input: ['resources/css/app.css', 'resources/js/app.js'],
                refresh: true,
                fonts: [
                    bunny('Instrument Sans', {
                        weights: [400, 500, 600],
                    }),
                ],
            }),
            tailwindcss(),
        ],
        server: {
            host: '0.0.0.0',
            port: devServerPort,
            strictPort: true,
            origin: devServerOrigin,
            cors: {
                origin: [
                    appOrigin,
                    /^https?:\/\/localhost(?::\d+)?$/,
                    /^https?:\/\/127\.0\.0\.1(?::\d+)?$/,
                ],
            },
            hmr: {
                host: devServerHost,
                port: devServerPort,
            },
            watch: {
                ignored: [
                    '**/storage/framework/views/**',
                    '**/bootstrap/cache/**',
                ],
                usePolling: false, // Explicitly disable polling watch for anti-polling logic and low CPU usage.
            },
        },
    };
});
