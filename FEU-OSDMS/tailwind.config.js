import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/View/ComponentViews.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['"Public Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                feu: {
                    green: '#004d32',
                    gold: '#FECB02',
                },
            },
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
