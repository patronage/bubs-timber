'use strict';

// load gulp and gulp plugins
import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
import dartSass from 'sass';
import gulpSass from 'gulp-sass';
import gulpEsbuild from 'gulp-esbuild';
import path from 'path';
import revAll from 'gulp-rev-all';
import { globalExternals } from '@fal-works/esbuild-plugin-global-externals';
import { readFile } from 'fs/promises';
const sass = gulpSass(dartSass);

const $ = plugins({
  config: path.join(process.cwd(), 'package.json'),
});

// load node modules
import { deleteSync } from 'del';
import pump from 'pump';
import beeper from 'beeper';

// others
import browserSync from 'browser-sync';
const server = browserSync.create();
//
// Gulp config
//

// Override defaults with custom local config

let localConfig;

try {
  const data = await readFile('./gulpconfig.json');
  localConfig = JSON.parse(data);
} catch (err) {
  localConfig = {
    gulp: {
      debug: false,
    },
    bs: {
      proxy: 'http://localhost:8000',
      logLevel: 'info',
      tunnel: '',
      open: true,
      notify: false,
    },
  };
}

// Build themeDir variable based on current theme from config file, fallback to default

const themeRoot = 'wp-content/themes/';
const theme = localConfig.activeTheme || 'timber';
const themeDir = themeRoot + theme;

// Defaults

const config = {
  theme: themeDir,
  assets: themeDir + '/assets',
  dist: themeDir + '/dist',
  dev: themeDir + '/dev',
  output: themeDir + '/dev', // default to dev
  static: themeDir + '/static',
  init: './_init',
};

// Esbuild project customizations
const esbuildConfig = {
  path: 'js',
  exclude: ['!**/assets/vendor/**', '!**/assets/js/lib/**', '!**/assets/js/charts/**'],
  include: [config.assets + '/{js}/calc/*'],
  globals: {
    jquery: '$',
  },
};

// in production tasks, we set this to true
let isProduction = false;

// Error Handling

const handleErrors = (err) => {
  if (err.message) {
    // note the error on console as well
    console.log(err.message);
  }

  // special variables for uglify
  if (err.cause) {
    err.message = err.cause.message;
    err.line = err.cause.line;
    err.column = err.cause.col;
  }

  // notifications
  if (err.line && err.column) {
    var notifyMessage = 'LINE ' + err.line + ':' + err.column + ' -- ';
  } else {
    var notifyMessage = '';
  }

  $.notify({
    title: 'FAIL: ' + err.plugin,
    message: notifyMessage + err.message,
  });

  beeper(); // System beep

  // Tell Travis to FAIL
  if (isProduction) {
    process.exit(1);
  }
};

//
// Gulp Tasks
//

const styles = (done) => {
  const sassOptions = {
    outputStyle: 'expanded',
  };

  pump(
    [
      gulp.src(config.assets + '/scss/*.scss', {
        sourcemaps: !isProduction,
      }),
      sass(sassOptions),
      $.if(isProduction, $.autoprefixer('last 2 versions')),
      $.if(isProduction, $.csso()),
      gulp.dest(config.output + '/css', { sourcemaps: !isProduction }),
      server.stream(),
    ],
    (err) => {
      if (err) {
        handleErrors(err);
        return done();
      } else {
        return done();
      }
    }
  );
};

const scripts = (done) => {
  const assets = $.useref({
    searchPath: config.assets,
    noconcat: true,
    import: function (content, target, options, alternateSearchPath) {
      console.log(content);
      console.log(target);
      console.log(options);
      console.log(alternateSearchPath);
      return content;
    },
  });

  const renameOptions = (path) => {
    path.dirname = 'js';
  };

  const filterExclusions = $.filter(['**', ...esbuildConfig.exclude], {
    restore: true,
  });

  pump(
    [
      gulp.src(config.theme + '/views/layout.twig'),
      assets,
      $.filter(['**', '!**/layout.twig'], { restore: true }),
      $.if(esbuildConfig.include.length > 0, gulp.src(esbuildConfig.include)),
      $.debug({
        title: 'scripts debug pre filter exclusions: ',
        showFiles: localConfig.gulp.debug,
      }),
      filterExclusions,
      $.debug({ title: 'scripts debug: ', showFiles: localConfig.gulp.debug }), // to debug files getting proccessed
      gulpEsbuild({
        outdir: '',
        sourcemap: isProduction ? false : 'inline',
        bundle: true,
        loader: {
          '.tsx': 'tsx',
          '.jsx': 'jsx',
          '.js': 'jsx',
        },
        target: 'es2015',
        plugins: [globalExternals(esbuildConfig.globals)],
      }),
      filterExclusions.restore,
      $.rename(renameOptions),
      $.debug({
        title: 'scripts debug after restore and rename: ',
        showFiles: localConfig.gulp.debug,
      }),
      gulp.dest(config.output, {}),
    ],
    (err) => {
      if (err) {
        handleErrors(err);
        return done();
      } else {
        return done();
      }
    }
  );
};

// When scripts runs, it creates extra files in copying from vendor we can delete
const cleanScripts = (done) => {
  deleteSync([config.output + '/wp-content']);
  done();
};

// copy unmodified files
const copy = (done) => {
  pump(
    [
      gulp.src(config.assets + '/{img,fonts,js}/**/*', {
        base: config.assets,
      }),
      $.newer(config.output),
      gulp.dest(config.output),
    ],
    done
  );
};

// loops through the generated html and replaces all references to static versions
const rev = (done) => {
  let extensions = [
    '.html',
    '.css',
    '.js',
    '.png',
    '.jpg',
    '.jpeg',
    '.gif',
    '.svg',
    '.woff',
    '.woff2',
    '.ttf',
    '.eot',
    '.otf',
  ];
  pump(
    [
      gulp.src(config.dist + '/{css,js,fonts,img}/**/*'),
      revAll.revision({
        dontSearchFile: [/\/js\/(?!charts).+/g],
        includeFilesInManifest: extensions,
      }),
      gulp.dest(config.static),
      revAll.manifestFile(),
      gulp.dest(config.static),
    ],
    (err) => {
      if (err) {
        handleErrors(err);
        return done();
      } else {
        return done();
      }
    }
  );
};

// clean output directory
export const clean = (done) => {
  deleteSync([config.dev, config.static, config.dist]);
  done();
};

const serve = (done) => {
  server.init({
    proxy: localConfig.bs.proxy,
    notify: localConfig.bs.notify || false,
    open: localConfig.bs.open || true,
    tunnel: localConfig.bs.tunnel || false,
    logLevel: localConfig.bs.logLevel || 'info',
  });

  gulp.watch(config.theme + '/**/*.{twig,php}', scripts, copy, reload);
  gulp.watch(config.assets + '/scss/**/*.scss', styles);
  gulp.watch(config.assets + '/js/**/*.js', gulp.series(scripts, copy, reload));
  gulp.watch(config.assets + '/{img,fonts}/**', gulp.series(copy, reload));

  done();
};

const reload = (done) => {
  server.reload();
  done();
};

//gulp release
export const release = (done) => {
  isProduction = true;
  config.output = config.dist;
  compile();
  done();
};

const compile = gulp.series(clean, styles, scripts, copy, cleanScripts, rev);
export const defaultTasks = gulp.series(clean, styles, scripts, copy, serve);

export default defaultTasks;
