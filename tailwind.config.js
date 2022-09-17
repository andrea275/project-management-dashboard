const defaultTheme = require('tailwindcss/defaultTheme');

const colorSaveList = [];
const colors = ['gray', 'yellow', 'orange', 'amber', 'red',  'blue', 'green', 'purple', 'pink'];

for (const key in colors) {
    colorSaveList.push(`text-${colors[key]}-500`);
    colorSaveList.push(`bg-${colors[key]}-500`);
    colorSaveList.push(`bg-${colors[key]}-400`);
    colorSaveList.push(`bg-${colors[key]}-100`);
}

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/js/**/*.vue',
        './resources/views/**/*.blade.php',
    ],

    safelist: colorSaveList,

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms')],
};
