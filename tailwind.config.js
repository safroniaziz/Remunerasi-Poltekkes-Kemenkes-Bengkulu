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
            colors: {
                navy: {
                    DEFAULT: '#152042',
                    dark: '#0d1530',
                    light: '#1e2d5a',
                },
                gold: {
                    DEFAULT: '#fbbf24',
                    dark: '#f59e0b',
                    light: '#fef3c7',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                heading: ['Plus Jakarta Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
