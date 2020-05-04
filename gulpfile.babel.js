'use strict';

// load gulp and gulp plugins
import gulp from 'gulp';
import plugins from 'gulp-load-plugins';
const $ = plugins();

$.sass.compiler = require('node-sass');

// load node modules
import del from 'del';
import pump from 'pump';
import beeper from 'beeper';
const stylish = require('jshint-stylish');

// others
import browserSync from 'browser-sync';
const server = browserSync.create();
//
// Gulp config
//

// Override defaults with custom local config

try {
    var localConfig = require('./gulpconfig.json');
} catch (err) {
    var localConfig = {
        bs: {
            proxy: "www.bubs.loc",
            logLevel: "info",
            tunnel: "",
            open: true,
            notify: false
        }
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
    init: './_init'
};


// in production tasks, we set this to true
let isProduction = false;

// Error Handling

const handleErrors = err => {
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
        message: notifyMessage + err.message
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

const styles = done => {
    const sassOptions = {
        outputStyle: 'expanded'
    };

    pump([gulp.src(config.assets + '/scss/*.scss', { sourcemaps: !isProduction }),
    $.sass(sassOptions),
    $.if(isProduction, $.autoprefixer('last 2 versions')),
    $.if(isProduction, $.csso()),
    gulp.dest(config.output + '/css', { sourcemaps: !isProduction }),
    server.stream()
    ], err => {
        if (err) {
            handleErrors(err);
            return done();
        } else {
            return done();
        }
    });
}

const scripts = done => {

    const assets = $.useref({
        searchPath: config.assets,
        noconcat: true,
    });

    const uglifyOptions = {
        mangle: false,
        compress: false
    };

    const renameOptions = path => {
        path.dirname = "js";
    };

    const f = $.filter(['**', '!**/assets/vendor/**', '!**/assets/js/lib/**'], { 'restore': true });

    pump([gulp.src(config.theme + '/views/layout.twig'),
        assets,
    $.filter(['**', '!**/layout.twig'], { 'restore': true }),
        f,
    $.jshint(),
    $.jshint.reporter(stylish),
    $.jshint.reporter('fail'),
    f.restore,
    $.rename(renameOptions),
    $.uglify(uglifyOptions),
    $.babel({
        presets: ['@babel/preset-env']
    }),
    gulp.dest(config.output)
    ], err => {
        if (err) {
            handleErrors(err);
            return done();
        } else {
            return done();
        }
    });
}

// When scripts runs, it creates extra files in copying from vendor we can delete
const cleanScripts = done => {
    del.sync([config.output + '/wp-content']);
    done();
}

// copy unmodified files
const copy = done => {
    pump([gulp.src(config.assets + '/{img,fonts,js}/**/*', { base: config.assets }),
    $.newer(config.output),
    gulp.dest(config.output)
    ], done);
}

// loops through the generated html and replaces all references to static versions
const rev = done => {
    pump([gulp.src(config.dist + '/{css,js,fonts,img}/**/*'),
    $.revAll.revision({ dontSearchFile: ['.js'] }),
    gulp.dest(config.static),
    $.revAll.manifestFile(),
    gulp.dest(config.static)],
        err => {
            if (err) {
                handleErrors(err);
                return done();
            } else {
                return done();
            }
        });
}

// write far futures expires headers for revved files
const staticHeaders = done => {
    pump([gulp.src(config.init + '/static.htaccess', { base: '' }),
    $.rename(".htaccess"),
    gulp.dest(config.static)],
        err => {
            if (err) {
                handleErrors(err);
                return done();
            } else {
                return done();
            }
        });
}

// clean output directory
export const clean = done => {
    del.sync([config.dev, config.static, config.dist]);
    done();
}

const serve = done => {
    server.init({
        proxy: localConfig.bs.proxy,
        notify: localConfig.bs.notify || false,
        open: localConfig.bs.open || true,
        tunnel: localConfig.bs.tunnel || false,
        logLevel: localConfig.bs.logLevel || 'info'
    });

    gulp.watch(config.theme + '/**/*.{twig,php}', reload);
    gulp.watch(config.assets + '/scss/**/*.scss', styles);
    gulp.watch(config.assets + '/js/**/*.js', gulp.series(scripts, reload));
    gulp.watch(config.assets + '/{img,fonts}/**', gulp.series(copy, reload));

    done();
}

const reload = done => {
    server.reload();
    done();
}

//gulp release
export const release = done => {
    isProduction = true;
    config.output = config.dist;
    compile();
    done();
}

const compile = gulp.series(clean, styles, scripts, copy, cleanScripts, rev, staticHeaders);
export const defaultTasks = gulp.series(clean, styles, copy, serve);

export default defaultTasks;