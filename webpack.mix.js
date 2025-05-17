const mix = require('laravel-mix');

// Compile SCSS to public/css/app.css
mix.sass('assets/scss/app.scss', 'public/css');

// Optionally include existing CSS files
mix.styles([
    'public/css/style.css',
    'public/css/app.css' // compiled SCSS result
], 'public/css/combined.css');
