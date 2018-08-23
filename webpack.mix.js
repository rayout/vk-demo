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
mix.webpackConfig({
    devtool: 'source-map'
})
mix.js('frontend/js/app.js', 'public/dist/js')
    .sass('frontend/style/app.scss', 'public/dist/css')
    .sourceMaps()
    .browserSync({
        proxy: 'vk-demo.localhost',
        files: ['public/dist/**/*']
    });
    //