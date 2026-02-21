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
                // Public Sans as the primary editorial font
                sans: ['"Public Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                feu: {
                    green: '#004d32',
                    gold: '#FECB02',
                    'green-dark': '#003321',
                    'slate-soft': '#F8FAFB',
                },
            },
            borderRadius: {
                '3xl': '1.5rem',
                '4xl': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
            }
        },
    },
    plugins: [require('@tailwindcss/forms')],
};
