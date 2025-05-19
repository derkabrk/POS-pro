const mix = require('laravel-mix');

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/scss/app.scss', 'public/css')
   .sass('resources/scss/bootstrap.scss', 'public/css')
   .sass('resources/scss/icons.scss', 'public/css')
   .sass('resources/scss/custom.scss', 'public/css');