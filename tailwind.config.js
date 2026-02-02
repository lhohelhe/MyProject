/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        admin: {
          sidebar: '#546A8C',
          orange: '#F0924E',
          green: '#28AE4E',
          red: '#FF0000',
        },
        sahabat: {
          blue: '#405272',
          orange: '#EDA05D',
        },
      },
      fontFamily: {
        jakarta: ['"Plus Jakarta Sans"', 'sans-serif'],
        catamaran: ['Catamaran', 'sans-serif'],
      },
    },
  },
  plugins: [],
}