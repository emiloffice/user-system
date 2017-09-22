let mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js')
    .sass('resources/assets/sass/footer.scss', 'public/css')
    .sass('resources/assets/sass/ambassador.scss', 'public/css')
    .sass('resources/assets/sass/reg.scss', 'public/css')
    .sass('resources/assets/sass/uc.scss', 'public/css')
    .sass('resources/assets/sass/login.scss', 'public/css')
    .sass('resources/assets/sass/app.scss', 'public/css');
mix.js('resources/assets/js/m.js', 'public/js')
    .sass('resources/assets/sass/m.scss', 'public/css')
    .sass('resources/assets/sass/m-reg.scss', 'public/css')
    .sass('resources/assets/sass/m-login.scss', 'public/css')
    .sass('resources/assets/sass/m-post.scss', 'public/css')
    .sass('resources/assets/sass/m-uc.scss', 'public/css');
if (mix.config.inProduction) {
    mix.version();
}