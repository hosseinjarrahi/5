const mix = require('laravel-mix');

mix.webpackConfig({
  resolve: {
    alias: {
      "@resources": path.resolve(
        __dirname,
        "resources"
      ),
      "@components": path.resolve(
        __dirname,
        "resources/js/components"
      ),
      "@sass": path.resolve(
        __dirname,
        "resources/sass"
      ),
      
    }
  }
});

mix.js('resources/js/app.js', 'public/js')
   .sass('resources/sass/app.scss', 'public/css/sass.css')
    .combine([
        'resources/sass/*.css',
        'public/css/sass.css',
    ],'public/css/app.css').version();
