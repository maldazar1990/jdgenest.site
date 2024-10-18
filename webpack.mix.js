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

mix.setPublicPath('public_html/')
    .js('resources/js/admin/app.js', 'admin/js/app.js')
    .sass('resources/sass/admin/app.scss', 'admin/css/app.css');

mix.setPublicPath('public_html/')
    .js('resources/js/app.js', 'front/js/app.js')
    .sass('resources/sass/app.scss', 'front/css/app.css');

if (mix.inProduction()) {
    mix.version();
}