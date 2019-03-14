// load gulp and gulp plugins
var gulp = require("gulp");
var $    = require('gulp-load-plugins')();

// load node modules
var del = require('del');
var fs = require('fs');
var runSequence = require('run-sequence');

var browserSync = require('browser-sync');

//
// Gulp config
//

// Override defaults with custom local config

try {
    var localConfig = require('./gulpconfig.json');
} catch (err) {
    var localConfig = {
        bs: {
            proxy: "www.bubs.dev",
            logLevel: "info",
            tunnel: "",
            open: false
        }
    };
}

// Build themeDir variable based on current theme from config file, fallback to default

var themeRoot = 'wp-content/themes/';
var theme = localConfig.activeTheme || 'timber';
var themeDir = themeRoot + theme;

// Defaults

var config = {
    theme: themeDir,
    assets: themeDir + '/assets',
    dist: themeDir + '/dist',
    dev: themeDir + '/dev',
    output: themeDir + '/dev', // default to dev
    static: themeDir + '/static',
    init: './_init'
};


// in production tasks, we set this to true
var isProduction = false;

// Error Handling

var handleErrors = function(err) {

    // console.log(err);

    // pretty error reporting
    var report = '\n';
    var chalk = $.util.colors.white.bgRed;

    // special variables for uglify
    if ( err.cause ){
        err.message = err.cause.message;
        err.line = err.cause.line;
        err.column = err.cause.col;
    }

    if (err.plugin) {
        report += chalk('PLUGIN:') + ' [' + err.plugin + ']\n';
    }

    if (err.message) {
        report += chalk('ERROR:\040') + ' ' + err.message + '\n';
    }

    console.error(report);

    // notifications
    if (err.line && err.column) {
        var notifyMessage = 'LINE ' + err.line + ':' + err.column + ' -- ';
    } else {
        var notifyMessage = '';
    }

    $.notify({
        title: 'FAIL: ' + err.plugin,
        message: notifyMessage + err.message,
    }).write(err);

    $.util.beep(); // System beep

    // Tell Travis to FAIL
    if ( isProduction ) {
        process.exit(1);
    }

    // Prevent the 'watch' task from stopping
    this.emit('end');
};

//
// Gulp Tasks
//

gulp.task('styles', function() {
    var sassOptions = {
        outputStyle: 'expanded'
    };

    var sourcemapsOptions = {
        debug: true
    };

    var nanoOptions = {
        autoprefixer: {
            browsers: ['> 1%', 'last 2 versions', 'IE >= 8'],
            add: true
        }
    };

    return gulp.src(config.assets + '/scss/*.scss')
        .pipe($.if(!isProduction, $.sourcemaps.init()))
        .pipe($.sass(sassOptions).on('error', handleErrors))
        .pipe($.if(isProduction, $.cssnano(nanoOptions)))
        .pipe($.if(!isProduction, $.sourcemaps.write(sourcemapsOptions)))
        .pipe(gulp.dest( config.output + '/css' ))
        .pipe(browserSync.stream());
});

gulp.task('scripts', function() {
    var assets = $.useref({
        searchPath: config.assets,
        noconcat: true,
    }).on('error', handleErrors);

    var uglifyOptions = {
        mangle: false,
        compress: false
    };

    var rename = function(path){
        path.dirname = "js";
    }

    return gulp.src( config.theme + '/views/layout.twig' )
        .pipe(assets)
        .pipe($.filter(['**', '!**/layout.twig'], {'restore': true}))
        .pipe($.copy( config.output ))
        .pipe($.rename(rename))
        .pipe($.uglify(uglifyOptions).on('error', handleErrors))
        .pipe(gulp.dest( config.output ));
});

// When scripts runs, it creates extra files in copying from vendor we can delete
gulp.task('clean:scripts', function (cb) {
    return del(config.output + '/wp-content', cb);
});

// copy unmodified files
gulp.task('copy', function (cb) {
    return gulp.src( config.assets + '/{img,fonts,js}/**/*', {base: config.assets})
        .pipe($.changed( config.output ))
        .pipe(gulp.dest( config.output ));
});

// loops through the generated html and replaces all references to static versions
gulp.task('rev', function (cb) {
    return gulp.src( config.dist + '/{css,js,fonts,img}/**/*' )
        .pipe($.rev())
        .pipe($.revCssUrl())
        .pipe(gulp.dest( config.static ))
        .pipe($.rev.manifest())
        .pipe(gulp.dest( config.static ))
});

// write far futures expires headers for revved files
gulp.task('staticHeaders', function() {
    return gulp.src( config.init + '/static.htaccess', { base: '' } )
        .pipe($.rename(".htaccess"))
        .pipe(gulp.dest( config.static ));
});

// clean output directory
gulp.task('clean', function (cb) {
    return del([config.dev, config.static, config.dist], cb);
});

gulp.task('browser-sync', function() {
    browserSync.init(null, {
        proxy: localConfig.bs.proxy,
        open: localConfig.bs.open || true,
        tunnel: localConfig.bs.tunnel || false,
        logLevel: localConfig.bs.logLevel || 'info'
    });

    gulp.watch(config.theme + '/**/*.{twig,php}').on('change', browserSync.reload);
    gulp.watch([config.assets + '/scss/**/*.scss'], ['styles']);
    gulp.watch(config.assets + '/js/**/*.js').on('change', browserSync.reload);
    gulp.watch(config.assets + '/{img,fonts}/**').on('copy', browserSync.reload);
});

//
// Multi-step tasks
//

// build production files
gulp.task('release', function (cb) {
    isProduction = true;
    config.output = config.dist;
    runSequence('clean', ['styles', 'scripts', 'copy'], ['clean:scripts', 'rev', 'staticHeaders'], cb);
});

gulp.task('default', function (cb) {
    runSequence('clean', ['styles', 'copy'], ['browser-sync'], cb);
});
