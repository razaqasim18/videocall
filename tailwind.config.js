export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./app/**/*.php",
        "./node_modules/flowbite/**/*.js",
    ],

    theme: {
        extend: {
            colors: {
                primary: '#35618E',
                secondary: '#9FCAFD',
                dark: '#191C20',
                surface: '#ffffff',
                background: '#F8F9FF',
            },

            fontFamily: {
                sans: ['Inter', 'sans-serif'],
            },

            borderRadius: {
                xl: '1rem',
                '2xl': '1.5rem',
            }
        },
    },

    plugins: [
        require('flowbite/plugin'), require('@tailwindcss/typography'),
    ],
};
