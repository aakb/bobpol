/* Set requirements */
var gulp = require('gulp'),
sass = require('gulp-sass'),
browsersync = require('browser-sync').create(),
gulpif = require('gulp-if'),
cssnano = require('gulp-cssnano'),
del = require('del'),
runsequence = require('run-sequence'),
plumber = require('gulp-plumber'),
gutil = require('gulp-util'),
uglify = require('gulp-uglify'),
rename = require('gulp-rename'),
concat = require('gulp-concat'),
autoprefixer = require('gulp-autoprefixer');

// Set paths
var scriptFiles = 'javascripts/*.js',
scriptDest = 'static/js',
styleFiles = 'scss/**/*.scss',
styleDest = 'static/css',
imgFiles = 'images/**/*.*',
imgDest = 'static/img',
fontFiles = 'fonts/**/*.*',
fontDest = 'static/fonts';




/* helper functions */
// handling errors
var onError = function (err) {
    gutil.log;
    console.log(err);
};
var jsMinify = function (file) {
    return file.path.indexOf('.min.js') == -1;
}

/* Define tasks */

// Cleanup dist folders
gulp.task('clean', function() {
    del.sync([
        styleDest,
        fontDest,
        imgDest,
        scriptDest
    ]);
});

// Copy fonts to dist
gulp.task('fonts', function() {
    // return gulp.src('node_modules/npm-font-open-sans/fonts/**/*')
    // .pipe(gulp.dest('dist/fonts/open-sans/'))
});

// Copy icons to dist
gulp.task('icons', function() {
    // return gulp.src('node_modules/@fortawesome/fontawesome-free-webfonts/webfonts/**/*')
    // .pipe(gulp.dest(fontDest + '/fontawesome/'))
});

// Copy scripts to static
gulp.task('scripts', function() {
    return gulp.src([
        scriptFiles ,
        'node_modules/jquery/dist/jquery.js',
        'node_modules/popper.js/dist/umd/popper.js',
        'node_modules/bootstrap/dist/js/bootstrap.js'
    ])
    .pipe(gulpif(jsMinify, uglify()))
    .pipe(gulpif(jsMinify, rename({ suffix: '.min' })))
    .pipe(gulp.dest(scriptDest))
    .pipe(browsersync.reload({ // Reload browser with changes
        stream: true
    }))
});

// Copy images to static
gulp.task('images', function() {
   return gulp.src(imgFiles)
   .pipe(gulp.dest(imgDest))
   .pipe(browsersync.reload({ // Reload browser with changes
       stream: true
   }))
});

// Compile scss to minifyed css
gulp.task('scss', function(){
    gulp.src(styleFiles)
    .pipe(plumber({ // More graceful error handling, prevents watch from breaking.
        errorHandler: onError
    }))
    .pipe(sass()) // Converts Sass to CSS with gulp-sass
    .pipe(autoprefixer({
        browsers: ['last 2 versions']
    }))
    .pipe(gulp.dest(styleDest)) // Destination for css
    .pipe(gulpif('*.css', cssnano())) // minifi the css file
    .pipe(browsersync.reload({ // Reload browser with changes
        stream: true
    }))
});

// Watch task for easy development
gulp.task('watch', [`default`], function(){
    gulp.watch(styleFiles, ['scss']);
    gulp.watch(scriptFiles, ['scripts']);
    gulp.watch(imgFiles, ['images']);
});

// Reload browser with watch task
gulp.task('browsersync', function() {
    browsersync.init({
        files: styleDest,
        proxy: "bobpol.vm",
        port: 8080

    })
});

// Default task when running gulp
gulp.task('default', function (callback) {
    runsequence(['clean', 'fonts', 'icons', 'scripts', 'images', 'scss'],
    callback
)
});

/********** Tasks not currently in use */

// Collect static css files
// gulp.task('static-css', function() {
//     return gulp.src(
//         'node_modules/add-to-homescreen/dist/style/addtohomescreen.css'
//     )
//     .pipe(gulp.dest('static/css/'))
// });
