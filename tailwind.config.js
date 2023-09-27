import { config as options } from './config.mjs';
const colors = require('tailwindcss/colors');

const allPlugins = {
  typography: require('@tailwindcss/typography'),
  forms: require('@tailwindcss/forms'),
  containerQueries: require('@tailwindcss/container-queries'),
  twElements: require('tw-elements/dist/plugin.cjs'),
};

const plugins = Object.keys(allPlugins)
  .filter((k) => options.plugins[k])
  .map((k) => {
    if (k in options.plugins && options.plugins[k]) {
      return allPlugins[k];
    }
  });

/** @type {import('tailwindcss').Config} */
module.exports = {
  // todo: should be variable
  content: [
    `${options.paths.root}/views/**/*.twig`,
    './node_modules/tw-elements/dist/js/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      orange: {
        50: '#fff3ed',
        100: '#ffe5d5',
        200: '#ffc6a9',
        300: '#ff9e72',
        400: '#fd5d27', // figma
        500: '#fc4513',
        600: '#ed2a09',
        700: '#c41b0a',
        800: '#9c1710',
        900: '#7d1711',
        950: '#440806',
      },
      'wild-sand': {
        50: '#f6f6f6',
        100: '#efefef',
        200: '#dcdcdc',
        300: '#bdbdbd',
        400: '#989898',
        500: '#7c7c7c',
        600: '#656565',
        700: '#525252',
        800: '#464646',
        900: '#3d3d3d',
        950: '#292929',
      },
      'teal-green': {
        50: '#effefb',
        100: '#c7fff4',
        200: '#90ffe8',
        300: '#51f7dc',
        400: '#1de4c9',
        500: '#04c8b0',
        600: '#00b09f', // figma
        700: '#058075',
        800: '#0a655e',
        900: '#0d544e',
        950: '#003332',
      },
      black: colors.black,
      white: colors.white,
      gray: colors.gray,
    },
    extend: {
      fontFamily: {
        sans: ['proxima-nova', 'sans-serif'],
      },
    },
  },
  plugins: plugins,
};
