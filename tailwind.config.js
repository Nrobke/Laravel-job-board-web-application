/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
        blur: {
            'extra-sm': '1.7px', // You can adjust the value to your preference
        },
    },
  },
  plugins: [
     require('@tailwindcss/forms')
  ],
}

