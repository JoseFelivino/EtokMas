const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            gridTemplateColumns: {
                'auto': 'repeat(auto-fit, minmax(200px, 1fr))'
            },
            maxWidth: {
                '48': '12rem/* 192px */',
                '52': '13rem/* 208px */',
            },
            minWidth: {
                '32': '8rem/* 128px */;',
                '48': '12rem/* 192px */',
                '96': '24rem/* 384px */',
                '4xl': '56rem/* 896px */;',
            },
            minHeight: {
                '10': '2.5rem/* 40px */',
                '96': '24rem/* 384px */',
            },
            flexGrow: {
              '1': 1,
              '2': 2,
            },
            zIndex: {
                '5': '5',
                '60': '60',
                '70': '70',
                '80': '80',
                '90': '90',
            },
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms')],
    important: true,
};
