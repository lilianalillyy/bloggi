
/**
 * This file is a part of the Bloggi CMS.
 *
 * The webpack configuration.
 * 
 * You may customize it to your needs, however using the module system is preferred.
 * 
 * @author Lilian
 */
const Encore = require('@symfony/webpack-encore');
const fs = require("fs");
const path = require("path");

/**
 * Configuration
 */

// Override the Encore build environment
const overrideEnv = null;

// The root directory of all scripts
const resourcesDir = path.join(__dirname, "resources");

// The root directory for all modules.
const modulesDir = path.join(resourcesDir, "modules");

// Allowed extensions for module entrypoint.
const moduleEntrypointExtensions = ["ts", "js"];

// File name of the module entrypoint (without the extension)
const moduleEntrypointName = "index";

/**
 * Helper functions
 */

/**
 * Resolves the module entry point in the root of the module's directory.
 * 
 * @param {string} moduleName
 * @throws {Error} When no entry point is found.
 * @return {string} Absolute path to the entry point.
 */
const resolveModuleEntrypoint = (moduleName) => {
    for (const ext of moduleEntrypointExtensions) {
        const pth = path.join(modulesDir, moduleName, `${moduleEntrypointName}.${ext}`);
        if (fs.existsSync(pth)) {
            return pth;
        }
    }

    throw new Error(
        `Cannot resolve module an entry point for module "${moduleName}"\n` +
        `Please create an entry point ${moduleEntrypointName}.{${moduleEntrypointExtensions.join(",")}} in the root of the module.`
    )
}

/**
 * Encore
 */

/**
 * If Encore's build environment is already not set (eg. via the encore command)
 * or the overrideEnv variable is set, set it based on the overrideEnv variable, 
 * NODE_ENV env variable or the production environment neither is set.
 */
if (overrideEnv || !Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(overrideEnv || process.env.NODE_ENV || 'prod');
}

Encore
    /**
     * Set the output of build files.
     */
    .setOutputPath('www/build/')
    /**
     * The public path to the output files accessible via the browser.
     */
    .setPublicPath('/build');

/**
 * Names of the modules in the modules directory. 
 * 
 * @type {string[]}
 */
 const modules = fs.readdirSync(modulesDir, { withFileTypes: true })
 .filter(res => res.isDirectory())
 .map(res => res.name);


/**
 * Registering modules
 */
for (const moduleName of modules) {
    Encore.addEntry(`${moduleName}Module`, resolveModuleEntrypoint(moduleName));
}

/**
 * Common configuration
 */
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
    .enableTypeScriptLoader()

module.exports = Encore.getWebpackConfig();
