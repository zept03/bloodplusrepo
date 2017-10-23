const { mix } = require('laravel-mix');

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

 mix.mix.copy('node_modules/bootstrap-sass/assets/fonts/bootstrap/','public/css/fonts')
.js('resources/assets/js/app.js', 'public/js')
.js('resources/assets/js/notif.js', 'public/js')
.sass('resources/assets/sass/app.scss', 'public/css');
