const config = {
  tailwindjs: './tailwind.config.js',
  port: 9050,
  purgecss: {
    content: ['src/**/*.{html,js,php,twig}'],
    safelist: {
      standard: [/^pre/, /^code/],
      greedy: [/token.*/],
    },
  },
};

// tailwind plugins
const plugins = {
  typography: true,
  forms: true,
  containerQueries: true,
  twElements: true,
};

// base folder paths
const basePaths = ['assets', 'dev', 'dist', 'static'];

// folder assets paths
const folders = ['css', 'js', 'img', 'fonts', 'vendor'];

const paths = {
  root: 'wp-content/themes/timber',
};

basePaths.forEach((base) => {
  paths[base] = {
    base: `./${paths.root}/${base}`,
  };
  folders.forEach((folderName) => {
    const toCamelCase = folderName.replace(/\b-([a-z])/g, (_, c) => c.toUpperCase());
    paths[base][toCamelCase] = `./${paths.root}/${base}/${folderName}`;
  });
});

config.paths = paths;
config.plugins = plugins;

export { config };
