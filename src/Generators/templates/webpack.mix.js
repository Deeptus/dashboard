const mix = require('laravel-mix');

mix.webpackConfig({
	externals: { Vue: 'vue' },
   /*optimization: {
      minimize: false,
      runtimeChunk: true,
      removeAvailableModules: false,
      removeEmptyChunks: false,
      splitChunks: false  
   },*/
	resolve: { symlinks: false }
})

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

mix.autoload({
    jquery: ['$',
    'window.jQuery',
    "jQuery",
    "window.$",
    "jquery",
    "window.jquery",
    'global.jQuery',
    "global.$",
    "global.jquery"
    ]
});

mix.js('resources/js/dashboard.js', 'public/js')
   .sass('resources/sass/dashboard.scss', 'public/css')
   .options({ processCssUrls: false });

mix.js('resources/js/website.js', 'public/js')
   .sass('resources/sass/website.scss', 'public/css')
   .options({ processCssUrls: false });

mix.disableNotifications();
mix.vue({ version: 2 });