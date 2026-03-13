/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php", // scan all blade files
        "./resources/**/*.js", // scan all JS files
        "./resources/**/*.vue", // optional if you use Vue
    ],
    theme: {
        extend: {},
    },
    plugins: [],
};
