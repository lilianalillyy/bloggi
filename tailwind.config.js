/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./app/Module/*/templates/**/*.{latte,phtml}', './resources/modules/**/*.{js,json}'],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Karla', 'sans-serif']
      }
    },
  },
  plugins: [],
}
