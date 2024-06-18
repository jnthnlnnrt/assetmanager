/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js"
  ],
  theme: {
    extend: {
      colors:{
          'dipak': {
          '50': '#f4f7fb',
          '100': '#e7eef7',
          '200': '#cadbed',
          '300': '#9cbedd',
          '400': '#679bc9',
          '500': '#447fb3',
          '600': '#336699',
          '700': '#2a517a',
          '800': '#264666',
          '900': '#243c56',
          '950': '#182739',
        },
      }
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

