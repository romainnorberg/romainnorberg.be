// This project uses "Yarn" package manager for managing JavaScript dependencies along
// with "Webpack Encore" library that helps working with the CSS and JavaScript files
// that are stored in the "assets/" directory.
//
// Read https://symfony.com/doc/current/frontend.html to learn more about how
// to manage CSS and JavaScript files in Symfony applications.
var Encore = require('@symfony/webpack-encore');
const CopyWebpackPlugin = require('copy-webpack-plugin');

Encore
  .setOutputPath('public/build/')
  .setPublicPath('/build')
  .cleanupOutputBeforeBuild()
  .enableSassLoader()
  // when versioning is enabled, each filename will include a hash that changes
  // whenever the contents of that file change. This allows you to use aggressive
  // caching strategies. Use Encore.isProduction() to enable it only for production.
  .enableVersioning(false)
  .addEntry('app', './assets/js/app.js')
  .addEntry('resume', './assets/js/resume.js')

  .addPlugin(new CopyWebpackPlugin([
    {from: 'assets/images', to: 'images', toType: 'dir', ignore: [".DS_Store"]},
  ]))

  .splitEntryChunks()
  .enableSingleRuntimeChunk()
  .enableIntegrityHashes(Encore.isProduction())
  .configureBabel(null, {
    useBuiltIns: 'usage',
    corejs: 3,
  })
;

module.exports = Encore.getWebpackConfig();
