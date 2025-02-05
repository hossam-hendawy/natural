module.exports = {
    plugins: [
        require('autoprefixer')({
            overrideBrowserslist: [
                '> 0.5%',
                'last 3 versions',
                'not dead',
                'Safari >= 12'
            ]
        })
    ]
};
