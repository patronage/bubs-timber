# Changes

- Implemented Docker container on the server side.
  - Automatically sets up WordPress as a development environment.
  - Uses Alpine images for Nginx and WordPress.
  - Server setup handled in singular .env file.
  - Mapped local `./src` folder to relevant theme folder on container.

- File Management Changes
  - Reduce project file scope down to theme files only, eliminate tracking of core and plugin files, handing responsibility of these to either Composer, WP Engine and the deployment process.

- Gulp Changes
  - `gulp-useref` dropped. There's already a very capable (and arguably better) JS processing and minification system with Babel/babelify/browserify. The way JS is currently loaded in twig templates is somewhat less than optimal and doesn't offer much in terms of benefits over a babelify-based option.
  - Added `@babel/plugin-transform-runtime` and `@babel/runtime` to the Babel transpiling process. See this link for more information: [https://babeljs.io/docs/en/babel-plugin-transform-runtime](https://babeljs.io/docs/en/babel-plugin-transform-runtime)
  - Switched to the [Airbnb preset](https://github.com/airbnb/babel-preset-airbnb) which utilizes the [Airbnb style guide](https://github.com/airbnb/javascript). Explanation on why it's better to come later.
  - Eliminated `gulp-if` from the development dependencies. Gulp can handle native JS conditionals.
  - Replaced `gulp-csso` with [cssnano](https://cssnano.co/) and `gulp-postcss` as it's a more comprehensive and extensible solution for SCSS processing.
  - `gulp-load-plugins` while useful isn't compatible with all Gulp scripts and leads to inconsistent package/function calls.
  - Removed `gulp-autoprefixer`, the core `autoprefixer` plugin works with `cssnano` without an additional layer of code.

- Front-end Dependencies
  - Bootstrap
