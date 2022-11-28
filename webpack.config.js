const Encore = require('@symfony/webpack-encore');
const fs = require("fs");
const path = require("path");

const RESOURCES_DIR = path.join(__dirname, "resources");
const MODULES_DIR = path.join(RESOURCES_DIR, "modules");

const modules = fs.readdirSync(MODULES_DIR, {withFileTypes: true})
        .filter(res => res.isDirectory())
        .map(res => res.name);

if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    .setOutputPath('www/build/')
    .setPublicPath('/build');

for (const moduleName of modules) {
    Encore.addEntry(`${moduleName}Module`, path.join(MODULES_DIR, moduleName, "index.js"));
}

Encore
    .disableSingleRuntimeChunk()
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    .enableVersioning(Encore.isProduction())
    .configureBabel((config) => {
        config.plugins.push('@babel/plugin-proposal-class-properties');
    })
    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })
    .enablePostCssLoader()
    .enableSassLoader()

module.exports = Encore.getWebpackConfig();
