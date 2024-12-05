/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js,php}"],
  theme: {
    extend: {
      colors: {
        'brown-super-hard': '#A45C40',
        'brown-hard': '#C38370',
        'brown-medium': '#E4B7A0',
        'brown-low': '#F6EEE0',
      },
    },
  },
  plugins: [],
}