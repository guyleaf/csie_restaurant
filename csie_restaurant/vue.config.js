const CompressionPlugin = require('compression-webpack-plugin');
const productionGzipExtensions = ['js', 'css'];
module.exports = {
    publicPath: process.env.NODE_ENV === 'production'
        ? '/CSIE_restaurant/dist/'
        : '/',
    outputDir: '../dist',
    productionSourceMap: false,
    chainWebpack(config) {
        config.plugins.delete('prefetch');
        config.plugin('CompressionPlugin').use(CompressionPlugin);
    },
    configureWebpack: config => {
        if (process.env.NODE_ENV === 'production') {
            // 生产环境
            config.plugins.push(
                new CompressionPlugin({
                    filename: '[path].gz[query]', // 提示示compression-webpack-plugin@3.0.0的话asset改为filename
                    algorithm: 'gzip',
                    test: new RegExp('\\.(' + productionGzipExtensions.join('|') + ')$'),
                    threshold: 10240,
                    minRatio: 0.8
                })
            );

        } else {
            // 开发环境

        }
    },
    pluginOptions: {
        webpackBundleAnalyzer: {
          openAnalyzer: false
        }
    }
}