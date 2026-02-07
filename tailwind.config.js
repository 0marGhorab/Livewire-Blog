import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    primary: '#ce6a6b',
                    secondary: '#ebaca2',
                    'button-secondary': '#d4958e',
                    'button-secondary-hover': '#c4847d',
                    'primary-hover': '#b85a5b',
                },
            },
        },
    },

    plugins: [forms],
};
