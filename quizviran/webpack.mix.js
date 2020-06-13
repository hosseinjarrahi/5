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
.sass('resources/css/app.scss', 'public/css/app.css');
