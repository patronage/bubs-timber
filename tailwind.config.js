import { config as options } from './config.mjs';
const colors = require('tailwindcss/colors');
const defaultTheme = require('tailwindcss/defaultTheme');

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
    `${options.paths.root}/*.php`,
    './node_modules/tw-elements/dist/js/**/*.js',
  ],
  darkMode: 'class',
  theme: {
    // https://uicolors.app/create
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      'science-blue': {
        50: '#ecf9ff',
        100: '#d4f0ff',
        200: '#b2e7ff',
        300: '#7ed9ff',
        400: '#41c2ff',
        500: '#15a0ff',
        600: '#007eff',
        700: '#0066fe',
        800: '#015adf', // from figma
        900: '#0849a0',
        950: '#0b2c60',
      },
      black: colors.black,
      white: colors.white,
      neutral: colors.neutral,
      gray: colors.gray,
    },
    extend: {
      aspectRatio: {
        social: '1200 / 628',
      },
      colors: {
        primary: 'rgba(var(--color-primary), <alpha-value>)',
        secondary: 'rgba(var(--color-secondary), <alpha-value>)',
        accent: 'rgba(var(--color-accent), <alpha-value>)',
        light: 'rgba(var(--color-light), <alpha-value>)',
        medium: 'rgba(var(--color-medium), <alpha-value>)',
        dark: 'rgba(var(--color-dark), <alpha-value>)',
      },
      fontFamily: {
        sans: ['Inter', ...defaultTheme.fontFamily.sans], // see if aileron is ok instead of neue haas unica
        serif: [...defaultTheme.fontFamily.serif],
        mono: [...defaultTheme.fontFamily.mono],
        body: ['Inter', ...defaultTheme.fontFamily.sans],
        heading: ['Archivo Black', ...defaultTheme.fontFamily.sans],
      },
    },
  },
  variants: {
    extend: {
      filter: ['hover'],
    },
  },
  safelist: ['animate-[fade-in_300ms_ease-in]'],
  plugins: plugins,
};
