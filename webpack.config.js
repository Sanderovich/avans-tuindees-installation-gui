const path = require('path');

module.exports = {
    mode: 'development',
    entry: './assets/index.js',
    output: {
        filename: 'app.js',
        path: path.resolve('public/js')
    },
    module: {
        rules: [{
            test: /\.scss$/,
            use: [
                "style-loader", // creates style nodes from JS strings
                "css-loader?url=false", // translates CSS into CommonJS
                "sass-loader" // compiles Sass to CSS, using Node Sass by default
            ]
        }]
    }
};