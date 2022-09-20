const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')

const colorSafeList = [];
const safeColors = ['gray', 'yellow', 'orange', 'amber', 'red', 'blue', 'green', 'purple', 'pink'];

for (const key in safeColors) {
    colorSafeList.push(`text-${safeColors[key]}-500`);
    colorSafeList.push(`bg-${safeColors[key]}-500`);
    colorSafeList.push(`bg-${safeColors[key]}-400`);
    colorSafeList.push(`hover:bg-${safeColors[key]}-400`);
    colorSafeList.push(`bg-${safeColors[key]}-100`);
}

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/js/**/*.vue',
        './resources/views/**/*.blade.php',
    ],
    safelist: colorSafeList,
    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: colors.blue
            }
        }
    },

    plugins: [require('@tailwindcss/forms')],
};
