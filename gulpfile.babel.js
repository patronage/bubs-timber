/**
 * -----------------------------------------------------------------------------
 * Module Import & Settings
 * -----------------------------------------------------------------------------
 */

// Import Gulp
import gulp from 'gulp';
import { argv } from 'yargs';
import del from 'del';
import path from 'path';

// Import CSS Modules
import autoprefixer from 'autoprefixer';
import easings from 'postcss-easings';
import mqp from 'css-mqpacker';
import nano from 'cssnano';
import postcss from 'gulp-postcss';
import sass from 'gulp-sass';
import sourcemaps from 'gulp-sourcemaps';

// Import Javascript Modules
import babel from 'babelify';
import browserify from 'browserify';
import buffer from 'vinyl-buffer';
import es from 'event-stream';
import glob from 'glob';
import plumber from 'gulp-plumber';
import source from 'vinyl-source-stream';
import uglify from 'gulp-uglify';
import watchify from 'watchify';

// Import Image Related Modules
import imagemin from 'gulp-imagemin';

// Import Utility Modules
import cache from 'gulp-cache';
import lineec from 'gulp-line-ending-corrector';
import log from 'fancy-log';
import rename from 'gulp-rename';

/**
 * -----------------------------------------------------------------------------
 * Configuration
 * -----------------------------------------------------------------------------
 */

// Script Settings
const config = {
    directory: {
        images: './src/assets/img/**/*',
        js: './src/assets/js/**/*.js',
        scss: './src/assets/scss/**/*.scss',
    },
};

// Runtime Variables
const isProduction = argv.production !== undefined;

/**
 * -----------------------------------------------------------------------------
 * Error Handler
 *
 * @param Mixed err
 * -----------------------------------------------------------------------------
 */

const errorHandler = (r) => {
    log.error('❌ ERROR: <%= error.message %>')(r);
};

/**
 * -----------------------------------------------------------------------------
 * Task: `init`.
 *
 * @description Initialization functions for the gulp task runner.
 * -----------------------------------------------------------------------------
 */

async function init() {
    log('🚀 — Initializing gulp tasks...');

    // Clear out assets directory before running.
    await del(['./src/dist']);

    // Clear image cache.
    await cache.clearAll();
}

gulp.task('init', gulp.series(init));

/**
 * -----------------------------------------------------------------------------
 * Task: `styles`.
 *
 * @description Compiles SCSS, Autoprefixes and minifies CSS.
 *
 * This task does the following:
 *    1. Gets the source SCSS files.
 *    2. Compiles SCSS to CSS.
 *    3. Combines media queries and autoprefixes with PostCSS.
 *    4. Writes the sourcemaps for it.
 *    5. Renames the CSS file to style.min.css.
 * -----------------------------------------------------------------------------
 */

gulp.task('styles', () => {
    log('⚡️ — Processing stylesheets...');

    let gulpTask = gulp
        .src(config.directory.scss, {
            allowEmpty: true,
        })
        .pipe(plumber(errorHandler));

    if (!isProduction) {
        gulpTask = gulpTask
            .pipe(
                rename((filePath) => ({
                    dirname: filePath.dirname,
                    basename: filePath.basename,
                    extname: '.css',
                })),
            )
            .pipe(
                sourcemaps.init({
                    loadMaps: true,
                }),
            );
    } else {
        gulpTask = gulpTask.pipe(
            rename((filePath) => ({
                dirname: filePath.dirname,
                basename: filePath.basename,
                extname: '.min.css',
            })),
        );
    }

    gulpTask = gulpTask
        .pipe(
            sass({
                errorLogToConsole: true,
                indentWidth: 4,
                outputStyle: !isProduction ? 'expanded' : 'compressed',
                precision: 10,
            }),
        )
        .on('error', sass.logError)
        .pipe(
            postcss([
                autoprefixer('defaults'),
                mqp({
                    sort: true,
                }),
                nano({
                    preset: [
                        'default',
                        {
                            normalizeWhitespace: !!isProduction,
                        },
                    ],
                }),
                easings(),
            ]),
        );

    if (!isProduction) gulpTask = gulpTask.pipe(sourcemaps.write('./'));

    gulpTask = gulpTask.pipe(lineec()).pipe(gulp.dest('./src/dist/css'));

    gulpTask = gulpTask.on('end', () => log('✅ STYLES — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `scripts`.
 *
 * @description Bundles javascript with Browserify.
 *
 * @todo Fill out a description for this section.
 * -----------------------------------------------------------------------------
 */

gulp.task('scripts', (done) => {
    log('⚙️ — Bundling scripts...');

    glob(config.directory.js, (err, files) => {
        if (err) done(err);

        const gulpTasks = files.map((entry) => {
            const entryName = entry.split(path.sep).slice(4).join('/');

            let bundler = browserify(entry, {
                debug: true,
            }).transform(babel);

            if (!isProduction) bundler = watchify(bundler);

            let bundleScripts = bundler
                .bundle()
                .pipe(plumber(errorHandler))
                .pipe(source(entryName))
                .pipe(buffer());

            if (!isProduction) {
                bundleScripts = bundleScripts.pipe(
                    sourcemaps.init({
                        loadMaps: true,
                    }),
                );
            }

            if (isProduction) bundleScripts = bundleScripts.pipe(uglify());

            if (!isProduction) {
                bundleScripts = bundleScripts.pipe(sourcemaps.write('./'));
            }

            bundleScripts = bundleScripts
                .pipe(lineec())
                .pipe(gulp.dest('./src/dist/js'));

            if (!isProduction) bundler.on('update', () => bundleScripts);

            return bundleScripts;
        });

        es.merge(gulpTasks).on('end', () => {
            log('✅ JS — completed!');
            done();
        });
    });
});

/**
 * -----------------------------------------------------------------------------
 * Task: `images`.
 *
 * @description Minifies PNG, JPEG, GIF and SVG images.
 *
 * This task does the following:
 *     1. Gets the source of images raw folder.
 *     2. Minifies PNG, JPEG, GIF and SVG images.
 *     3. Generates and saves the optimized images.
 * -----------------------------------------------------------------------------
 */

gulp.task('images', () => {
    log('📷 — Processing images...');

    let gulpTask = gulp
        .src(config.directory.images)
        .pipe(
            cache(
                imagemin([
                    imagemin.gifsicle({
                        interlaced: true,
                        optimizationLevel: 2,
                        colors: 256,
                    }),
                    imagemin.jpegtran({
                        progressive: true,
                        arithmetic: false,
                    }),
                    imagemin.optipng({
                        optimizationLevel: 3,
                        bitDepthReduction: true,
                        colorTypeReduction: true,
                        paletteReduction: true,
                    }),
                    imagemin.svgo({
                        plugins: [
                            {
                                removeViewBox: false,
                            },
                            {
                                cleanupIDs: false,
                            },
                        ],
                    }),
                ]),
            ),
        )
        .pipe(gulp.dest('./dist/assets/img'));

    gulpTask = gulpTask.on('end', () => log('✅ IMAGES — completed!'));

    return gulpTask;
});

/**
 * -----------------------------------------------------------------------------
 * Task: `watch`.
 *
 * @description Watch tasks for the gulp processes.
 * -----------------------------------------------------------------------------
 */

gulp.task('watch', () => {
    log('🔍 — Watching files for changes...');

    gulp.watch(config.directory.images, gulp.series('images'));
    gulp.watch(config.directory.js, gulp.series('scripts'));
    gulp.watch(config.directory.scss, gulp.series('styles'));
});

/**
 * -----------------------------------------------------------------------------
 * Task: `default`.
 *
 * @description Runs gulp tasks and initializes browserSync and watches files.
 * -----------------------------------------------------------------------------
 */

gulp.task(
    'default',
    gulp.series(
        init,
        gulp.parallel('styles', 'scripts', /*'images', */ 'watch'),
    ),
);
