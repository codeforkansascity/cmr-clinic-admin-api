const mix = require('laravel-mix');

require('laravel-mix-copy-watched');

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
    output: {
        // Chunks in webpack
        publicPath: '/',
        chunkFilename: 'js/components/[name].js',
    },
});

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .copyDirectoryWatched('resources/img/**/*', 'public/img', { base: 'resources/img' });

if (mix.inProduction()) {
    mix.version();
}
