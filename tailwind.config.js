/** @type {import('tailwindcss').Config} */
export default {
    content: [
        // You will probably also need these lines
        "./resources/**/**/*.blade.php",
        "./resources/**/**/*.js",
        "./app/View/Components/**/**/*.php",
        "./app/Livewire/**/**/*.php",

        // Add mary
        "./vendor/robsontenorio/mary/src/View/Components/**/*.php",
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",

        "./vendor/joshhanley/livewire-autocomplete/resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            primary: '#005b96',
            secondary: '#ff6600',
            accent: '#27282e',
            neutral: '#1c1917',
            warning: '#e3af00',
            backgroundImage: {
                'login-background': "url('/resources/images/login-background.png')",
            }
        },
    },

    // Add daisyUI
    plugins: [require("daisyui")],

    daisyui: {
        themes: [
            {
                mytheme: {
                    'primary': '#005b96',
                    'secondary': '#FECC02',
                    'accent': '#27282e',
                    'neutral': '#060109',
                    'base-100': '#F8F8FF',
                    'base-200': '#f3f3f3',
                    'base-300': '#090909',
                    'info': '#0081d4',
                    'success': '#81c784',
                    'warning': '#e3af00',
                    'error': '#d47b7b',
                    'info-content': '#ffffff',
                    'success-content': '#0D3B12',
                    'warning-content': '#ffffff',
                    'error-content': '#ffffff',
                },
            },
        ],
    },
}
