const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.react('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/app.scss', 'public/css')
    .browserSync({
        proxy: 'https://stm.test',
        port: 3300,
        https: {
            key: '/Users/leonmagee/.localhost-ssl/key.pem',
            cert: '/Users/leonmagee/.localhost-ssl/cert.pem',
        },
    });

// mix.js('resources/assets/js/app.js', 'public/js')
// .sass('resources/assets/sass/app.scss', 'public/css').version().disableNotifications();
