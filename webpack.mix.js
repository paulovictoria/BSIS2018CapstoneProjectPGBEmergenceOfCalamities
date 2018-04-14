const mix = require("laravel-mix");
const imageminMozjpeg = require("imagemin-mozjpeg");
const ImageminPlugin = require("imagemin-webpack-plugin").default;

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

mix
  .js("resources/assets/js/app.js", "public/js")
  .js("resources/assets/js/home.js", "public/js")
  .js("resources/assets/js/log.js", "public/js")
  .js("resources/assets/js/rescue.js", "public/js")
  .js("resources/assets/js/console.js", "public/js")
  .sass("resources/assets/sass/home.scss", "public/css")
  .sass("resources/assets/sass/app.scss", "public/css")
  .sass("resources/assets/sass/pdf.scss", "public/css")
  .styles(
    ["resources/assets/sass/libs/bootstrap.min.css"],
    "public/css/vendor.css"
  )
  .scripts("resources/assets/js/libs/bootstrap.min.js", "public/js/vendor.js")
  .options({
    processCssUrls: false
  })
  .webpackConfig({
    plugins: [
      new ImageminPlugin({
        test: /\.(jpe?g|png|gif|svg)$/i,
        plugins: [
          imageminMozjpeg({
            quality: 80
          })
        ]
      })
    ]
  });
