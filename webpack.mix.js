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
    .js('resources/js/admin/app.js', 'public_html/admin/js/app.js')
    .sass('resources/sass/admin/app.scss', 'public_html/admin/css/app.css');

mix.setPublicPath('public_html/')
    .js('resources/js/app.js', 'public_html/front/js/app.js')
    .sass('resources/sass/app.scss', 'public_html/front/css/app.css');

if (mix.inProduction()) {
    mix.version();
    mix.minify('public_html/admin/css/app.css');
    mix.minify('public_html/front/css/app.css');
    mix.minify('public_html/admin/js/app.js');
    mix.minify('public_html/front/js/app.js');
}