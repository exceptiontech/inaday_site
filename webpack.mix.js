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

mix.js('resources/assets/frontend/js/app.js', 'public/assets/frontend/js')
   .sass('resources/assets/frontend/sass/app.scss', 'public/assets/frontend/css')
   .sass('resources/assets/frontend/sass/app-rtl.scss', 'public/assets/frontend/css/rtl')
   // .sass('resources/assets/dashboard/sass/dashboard.scss', 'public/assets/dashboard/css')
   // .sass('resources/assets/dashboard/sass/dashboard-rtl.scss', 'public/assets/dashboard/css');

    .sass(
        "resources/assets/dashboard/sass/themes/lite-blue.scss",
        "public/assets/dashboard/css"
    );

mix.combine(
    [
        "resources/assets/dashboard/js/vendor/jquery-3.3.1.min.js",
        "resources/assets/dashboard/js/vendor/bootstrap.bundle.min.js",
        "resources/assets/dashboard/js/vendor/perfect-scrollbar.min.js"
    ],
    "public/assets/dashboard/js/app.js"
);

mix.js(["resources/assets/dashboard/js/script.js"], "public/assets/dashboard/js/script.js");

