const path = require('path');


module.exports = {

    context: path.resolve(__dirname, 'src'),

    entry: './init.js',

    output: {
        filename: 'bundle.js',
        path: path.resolve(__dirname, '../public/js')
    },

    resolve: {
        extensions: ['.js']
    },

    watch: false

};