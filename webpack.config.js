// Import de path natif de Node.js pour le chemin de fichiers
const path = require('path');
// Import de Encore pour la configuration Symfony
const Encore = require('@symfony/webpack-encore');

// Configure l'environnement d'exécution de Webpack Encore
Encore.configureRuntimeEnvironment('development');

// Configure Encore (il faut le faire avant d'appeler setOutputPath)
Encore
    .setOutputPath('public/build/')
    .setPublicPath('/build')
    .addEntry('app', './assets/app.js') // S'assure que 'app' existe bien
    .enableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .enableSassLoader()
    .enablePostCssLoader() // Optionnel, pour utiliser Autoprefixer
    .splitEntryChunks()
    .autoProvidejQuery()
    .enableVersioning()
    .addStyleEntry('css/main', './assets/scss/main.scss');

// Exporte la configuration générée par Encore
module.exports = Encore.getWebpackConfig();



