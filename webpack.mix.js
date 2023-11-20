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

mix.js('resources/js/app.js', 'public/assets/binancedoge/js')
    .sass('resources/sass/app.scss', 'public/assets/binancedoge/css');

mix.styles([
        'resources/lib/bootstrap/css/bootstrap.min.css',
        //'resources/css/custom.css',
    ], 'public/assets/binancedoge/css/all.css');


