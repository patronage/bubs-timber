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
    colors: {
      transparent: 'transparent',
      current: 'currentColor',
      black: colors.black,
      white: colors.white,
      neutral: colors.neutral,
      gray: colors.gray,
    },
    extend: {
      aspectRatio: {
        social: '1200 / 630',
      },
      colors: {
        primary: 'rgba(var(--color-primary), <alpha-value>)',
        secondary: 'rgba(var(--color-secondary), <alpha-value>)',
        accent: 'rgba(var(--color-accent), <alpha-value>)',
        sand: 'rgba(var(--color-light), <alpha-value>)',
        light: 'rgba(var(--color-light), <alpha-value>)',
        medium: 'rgba(var(--color-medium), <alpha-value>)',
        dark: 'rgba(var(--color-dark), <alpha-value>)',
        orange: 'rgba(var(--color-orange), <alpha-value>)',
        green: 'rgba(var(--color-green), <alpha-value>)',
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
        serif: [...defaultTheme.fontFamily.serif],
        mono: [...defaultTheme.fontFamily.mono],
        body: ['Inter', ...defaultTheme.fontFamily.sans],
        heading: ['Inter', ...defaultTheme.fontFamily.sans],
      },
      // If updating screens, make sure to update _variables.scss, and components/tailwind-indicators.twig
      screens: {},
    },
  },
  variants: {
    extend: {
      filter: ['hover'],
    },
  },
  // Add classes that we want to allow before purging
  safelist: ['animate-[fade-in_300ms_ease-in]'],
  plugins: [
    ...plugins,
    function ({ addUtilities }) {
      const newUtilities = {
        '.animate-fill-forwards': {
          'animation-fill-mode': 'forwards',
        },
        // coming in future: https://github.com/tailwindlabs/tailwindcss/discussions/11486
        '.text-balance': {
          'text-wrap': 'balance',
        },
      };
      addUtilities(newUtilities);
    },
  ],
};
