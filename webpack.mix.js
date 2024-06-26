const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js("resources/js/app.js", "public/js")
    .postCss("resources/css/app.css", "public/css")
    .postCss("resources/css/sign-in.css", "public/css")
    .postCss("resources/css/dashboard.css", "public/css")
    .sass("resources/sass/app.scss", "public/css")
    .copy("node_modules/sweetalert2/dist/sweetalert2.min.css", "public/css")
    .copy("node_modules/sweetalert2/dist/sweetalert2.all.min.js", "public/js")
    .copy('node_modules/filepond/dist/filepond.css', 'public/css')
    .copy('node_modules/filepond/dist/filepond.min.js', 'public/js')
    .copy('node_modules/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.min.js', 'public/js')
    .copy('node_modules/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js', 'public/js')
    .copy('node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css', 'public/css')
    .copy('node_modules/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js', 'public/js')
    .copy('node_modules/jquery-filepond/filepond.jquery.js', 'public/js')
    .sourceMaps();
