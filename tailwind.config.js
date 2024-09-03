
/** @type {import('tailwindcss').Config} */
const defaultTheme = require('tailwindcss/defaultTheme')
const colors = require('tailwindcss/colors')

export default {
  darkMode: "class",
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
    "./node_modules/flowbite/**/*.js",
    "./app/Helpers/PowerGridThemes/*.php",
    "./vendor/power-components/livewire-powergrid/resources/views/**/*.php",
    "./vendor/power-components/livewire-powergrid/src/Themes/Tailwind.php"
  ],
  presets: [
    require("./vendor/power-components/livewire-powergrid/tailwind.config.js"),
  ],
  theme: {
    extend: {
      colors: {
        'primary': {
          '50': '#edf8ff',
          '100': '#d6eeff',
          '200': '#b6e3ff',
          '300': '#84d3ff',
          '400': '#4ab9ff',
          '500': '#2097ff',
          '600': '#0877ff',
          '700': '#025ff3',
          '800': '#094cc4',
          '900': '#0e439a',
          '950': '#0e2a5d',
        },
        "pg-primary": colors.gray,
      },
      fontFamily: {
        sans: ['Inter var', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  plugins: [
    require('flowbite/plugin')
  ],
}

