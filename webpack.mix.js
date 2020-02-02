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

mix.react('resources/js/app.js', 'public/js')
.sass('resources/sass/app.scss', 'public/css')
.sass('resources/sass/review.scss', 'public/css');

mix.js('resources/js/site/welcome.js', 'public/js/site');
mix.js('resources/js/script.js', 'public/js');
mix.js('resources/js/site/add-post.js', 'public/js/site');
mix.js('resources/js/site/profile.js', 'public/js/site');
mix.js('resources/js/site/review.js', 'public/js/site');
mix.react('resources/js/components/Posts.js', 'public/js/components');
// mix.copyDirectory('resources/js/site', 'public/js/site');