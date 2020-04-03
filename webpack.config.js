var Encore = require('@symfony/webpack-encore');

// Manually configure the runtime environment if not already configured yet by the "encore" command.
// It's useful when you use tools that rely on webpack.config.js file.
if (!Encore.isRuntimeEnvironmentConfigured()) {
    Encore.configureRuntimeEnvironment(process.env.NODE_ENV || 'dev');
}

Encore
    // directory where compiled assets will be stored
    .setOutputPath('public/build/')
    // public path used by the web server to access the output path
    .setPublicPath('/build')
    // only needed for CDN's or sub-directory deploy
    //.setManifestKeyPrefix('build/')

    /*
     * ENTRY CONFIG
     *
     * Add 1 entry for each "page" of your app
     * (including one that's included on every page - e.g. "app")
     *
     * Each entry will result in one JavaScript file (e.g. app.js)
     * and one CSS file (e.g. app.css) if your JavaScript imports CSS.
     */
    .addEntry('app', './assets/js/app.js')

    // TEMPLATE //
    
    // SECURITY

    .addEntry('resetPass', './assets/css/Security/resetPass.css')
    .addEntry('registration', './assets/css/Security/registration.css')
    .addEntry('login', './assets/css/Security/login.css')
    .addEntry('indexSecurity', './assets/css/Security/indexSecurity.css')
    .addEntry('forgottenPass', './assets/css/Security/forgottenPass.css')

    // PROFIL USER

    .addEntry('index', './assets/css/ProfilUser/index.css')
    .addEntry('update', './assets/css/ProfilUser/update.css')

    // PRODUCT

    .addEntry('_card', './assets/css/Product/_card.css')
    .addEntry('_filter', './assets/css/Product/_filter.css')
    .addEntry('product', './assets/css/Product/product.css')
    .addEntry('comment', './assets/js/comment.js')

    //ORDER

    .addEntry('check_order', './assets/css/Order/check_order.css')
    .addEntry('indexOrder', './assets/css/Order/indexOrder.css')

    // NAVBAR

    .addEntry('indexNavbar', './assets/css/indexNavbar.css')

    // HOMEPAGE

    .addEntry('indexHomepage', './assets/css/indexHomepage.css')

    // EMAILS

    .addEntry('orderConfirmed', './assets/css/Emails/orderConfirmed.css')
    .addEntry('recreatePass', './assets/css/Emails/recreatePass.css')

    // CONTACT_FORM

    .addEntry('indexContact', './assets/css/indexContact.css')

    // CART

    .addEntry('_cartDisplay', './assets/css/Cart/_cartDisplay.css')
    .addEntry('indexCart', './assets/css/Cart/indexCart.css')

    // ADDRESS

    .addEntry('_cartAddress', './assets/css/Address/_cardAddress.css')
    .addEntry('_formAddress', './assets/css/Address/_formAddress.css')























    //.addEntry('page1', './assets/js/page1.js')
    //.addEntry('page2', './assets/js/page2.js')

    // When enabled, Webpack "splits" your files into smaller pieces for greater optimization.
    .splitEntryChunks()

    // will require an extra script tag for runtime.js
    // but, you probably want this, unless you're building a single-page app
    .enableSingleRuntimeChunk()

    /*
     * FEATURE CONFIG
     *
     * Enable & configure other features below. For a full
     * list of features, see:
     * https://symfony.com/doc/current/frontend.html#adding-more-features
     */
    .cleanupOutputBeforeBuild()
    .enableBuildNotifications()
    .enableSourceMaps(!Encore.isProduction())
    // enables hashed filenames (e.g. app.abc123.css)
    .enableVersioning(Encore.isProduction())

    // enables @babel/preset-env polyfills
    .configureBabelPresetEnv((config) => {
        config.useBuiltIns = 'usage';
        config.corejs = 3;
    })

    // enables Sass/SCSS support
    // .enableSassLoader()

    // uncomment if you use TypeScript
    //.enableTypeScriptLoader()

    // uncomment to get integrity="..." attributes on your script & link tags
    // requires WebpackEncoreBundle 1.4 or higher
    //.enableIntegrityHashes(Encore.isProduction())

    // uncomment if you're having problems with a jQuery plugin
    .autoProvidejQuery()

    // uncomment if you use API Platform Admin (composer req api-admin)
    //.enableReactPreset()
    //.addEntry('admin', './assets/js/admin.js')

    .copyFiles({
        from: './assets/images',
        to: 'images/[path][name].[hash:8].[ext]',
        pattern: /\.(png|jpg|jpeg)$/
    })
    .configureWatchOptions(function(watchOptions) {
        // enable polling and check for changes every 250ms
        // polling is useful when running Encore inside a Virtual Machine
        watchOptions.poll = 250;
    })
;

module.exports = Encore.getWebpackConfig();