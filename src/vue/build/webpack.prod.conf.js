const path = require('path');
const utils = require('./utils');
const webpack = require('webpack');
const config = require('../config');
const merge = require('webpack-merge');
const baseWebpackConfig = require('./webpack.base.conf');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const OptimizeCSSPlugin = require('optimize-css-assets-webpack-plugin');
const UglifyJsPlugin = require('uglifyjs-webpack-plugin');

const env = require('../config/prod.env');

const webpackConfig = merge(baseWebpackConfig, {
    module: {
        rules: utils.styleLoaders({
            sourceMap: config.build.productionSourceMap,
            extract: true,
            usePostCSS: true
        })
    },
    devtool: config.build.productionSourceMap ? config.build.devtool : false,
    output: {
        path: config.build.assetsRoot,
        filename: utils.assetsPath('js/x_builder.js'),
        chunkFilename: utils.assetsPath('js/[id].js')
    },
    plugins: [
        // http://vuejs.github.io/vue-loader/en/workflow/production.html
        new webpack.DefinePlugin({
            'process.env': env
        }),
        new UglifyJsPlugin({
            parallel: true,
            uglifyOptions: {
                toplevel: false,
            }
        }),
        // extract css into its own file
        new ExtractTextPlugin({
            filename: utils.assetsPath('css/[name].css'),
            allChunks: true,
        }),
        // Compress extracted CSS. We are using this plugin so that possible
        // duplicated CSS from different components can be deduped.
        new OptimizeCSSPlugin({
            cssProcessorOptions: config.build.productionSourceMap
                ? {safe: true, map: {inline: false}}
                : {safe: true}
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: 'node-static',
            filename: 'static/js/node-static.js',
            minChunks(module, count) {
                let context = module.context;
                return context && context.indexOf('node_modules') >= 0;
            },
        }),
        new webpack.optimize.CommonsChunkPlugin({
            name: 'vue',
            filename: 'static/js/vue.js',
            minChunks(module, count) {
                let context = module.context;
                let resource = module.resource;
                let target = resource.indexOf('vue.esm.js') > 0 || resource.indexOf('vue-resource.esm.js') > 0;
                return context && context.indexOf('node_modules') >= 0 && target;
            },
        }),
        new webpack.HashedModuleIdsPlugin()
    ]
});

if (config.build.productionGzip) {
    const CompressionWebpackPlugin = require('compression-webpack-plugin')

    webpackConfig.plugins.push(
        new CompressionWebpackPlugin({
            asset: '[path].gz[query]',
            algorithm: 'gzip',
            test: new RegExp(
                '\\.(' +
                config.build.productionGzipExtensions.join('|') +
                ')$'
            ),
            threshold: 10240,
            minRatio: 0.8
        })
    )
}

if (config.build.bundleAnalyzerReport) {
    const BundleAnalyzerPlugin = require('webpack-bundle-analyzer').BundleAnalyzerPlugin;
    webpackConfig.plugins.push(new BundleAnalyzerPlugin())
}

module.exports = webpackConfig;
