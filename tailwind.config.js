const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors:{
                "primary": {
                    "DEFAULT": "#075985",
                    "hover": "#38bdf8",
                    "dark": {
                        "DEFAULT": "#0c4a6e",
                        "text": "#ffffff"
                    },
                    "light": "#e0f2fe",
                    "text": "#ffffff"
                },
                "secondary": {
                    "DEFAULT": "#C5C9CC",
                    "hover": "#B8BDC0",
                    "dark": "#A9ADB0",
                    "light": "#D9DBDC",
                    "text": "#ffffff"
                },
                "danger": {
                    "DEFAULT": "#8f2f34",
                    "hover": "#66181c",
                    "dark": "#8F4E4E",
                    "light": "#DF9C9C",
                    "text": "#f2f1ec"
                },
                "info": {
                    "DEFAULT": "#289cd2",
                    "hover": "#1c78a3",
                    "dark": "#4A7B8F",
                    "light": "#90BDD2",
                    "text": "#f2f1ec"
                },
                "warning": {
                    "DEFAULT": "#41c1bb",
                    "hover": "#25807b",
                    "dark": "#8F674E",
                    "light": "#DFBD9C",
                    "text": "#f2f1ec"
                },
                "success": {
                    "DEFAULT": "#2d8549",
                    "hover": "#186631",
                    "dark": "#4E8F62",
                    "light": "#9CD9B2",
                    "text": "#f2f1ec",
                    "disabled": {
                        "DEFAULT": "#3a403c",
                        "text": "#aaaaaa"
                    }
                },
                "disabled": {
                    "DEFAULT": "#AAAAAA",
                    "text": "#888888",
                }
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
