module.exports = {
  semi: true,
  trailingComma: 'es5',
  singleQuote: true,
  printWidth: 90,
  phpVersion: '7.4',
  braceStyle: '1tbs',
  twigPrintWidth: 100,
  plugins: [
    'prettier-plugin-tailwindcss',
    './node_modules/@supersoniks/prettier-plugin-twig-melody',
  ],
  overrides: [
    {
      files: '*.php',
      options: {
        printWidth: 120,
      },
    },
  ],
};
