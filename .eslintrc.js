module.exports = {
  env: {
    browser: true,
    commonjs: true,
    es6: true,
    node: true,
  },
  plugins: ['import'],
  parserOptions: {
    sourceType: 'module',
    ecmaVersion: 2017,
  },
  extends: ['eslint:recommended', 'plugin:react/recommended', 'prettier'],
  settings: {
    react: {
      version: 'detect',
    },
  },
  globals: {
    analytics: true,
    FB: true,
    ga: true,
    google: true,
    gtag: true,
  },
  rules: {
    // "no-console": ["warn", 0],
    'no-console': ['warn', { allow: ['warn', 'error'] }],
    indent: 'off', // conflicts with prettier
    'linebreak-style': ['error', 'unix'],
    'no-unused-vars': 'warn',
    quotes: [
      'error',
      'single',
      {
        avoidEscape: true,
      },
    ],
    semi: ['error', 'always'],

    // Import
    'import/order': ['error', { alphabetize: { order: 'asc', caseInsensitive: true } }],

    // React
    'react/prop-types': 0,
    // suppress errors for missing 'import React' in files
    'react/react-in-jsx-scope': 'off',
    // NextJs specific fix: allow jsx syntax in js files
    'react/jsx-filename-extension': [1, { extensions: ['.js', '.jsx', '.ts', '.tsx'] }], //should add ".ts" if typescript project
    'react/display-name': 1,

    // React Hooks
    'react-hooks/exhaustive-deps': 'off',
  },
};
