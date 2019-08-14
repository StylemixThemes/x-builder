var
    gulp = require('gulp'),
    browserSync = require('browser-sync'),
    $ = require('gulp-load-plugins')({lazy: true});

const babel = require('gulp-babel');

gulp.task('styles', function () {
    return gulp
        .src('./src/sass/**/*.scss')
        .pipe($.sass().on('error', $.sass.logError))
        .pipe($.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe($.cleanCss())
        .pipe(gulp.dest('public/css'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('vendorScripts', function () {
    gulp.src('./src/js/vendor/**/*.js')
        .pipe(gulp.dest('public/js/vendor'));

    gulp.src('./src/sass/vendors/**/*.css')
        .pipe(gulp.dest('public/css/vendor'));
});

gulp.task('modules_scripts', function () {
    return gulp
        .src([
            './src/js/modules/*.js',
        ])
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .on('error', console.error.bind(console))
        .pipe(gulp.dest('public/js/modules'))
        .pipe(browserSync.reload({stream: true}));
});

gulp.task('admin_scripts', function () {
    return gulp
        .src([
            './src/js/admin/*.js',
        ])
        .pipe(babel({
            presets: ['@babel/env']
        }))
        .on('error', console.error.bind(console))
        .pipe(gulp.dest('public/js/admin'))
        .pipe(browserSync.reload({stream: true}));
});

// Optimizes the images that exists
gulp.task('images', function () {
    return gulp
        .src('src/images/**')
        .pipe($.changed('images'))
        .pipe($.imagemin({
            // Lossless conversion to progressive JPGs
            progressive: true,
            // Interlace GIFs for progressive rendering
            interlaced: true
        }))
        .pipe(gulp.dest('public/images'))
        .pipe($.size({title: 'images'}));
});

gulp.task('browser-sync', ['styles', 'modules_scripts', 'admin_scripts'], function () {
    browserSync.init({
        proxy: "http://elab.loc",
        host: "192.168.0.124",
        port: 3000,
        notify: true,
        ui: {
            port: 3001
        },
        open: false
    });
});

gulp.task('deploy', function () {
    return gulp
        .src('./public/**/*')
        .pipe(ghPages());
});

gulp.task('watch', function () {
    // Watch .sass files
    gulp.watch('src/sass/**/*.scss', ['styles']);
    // Watch .js files
    gulp.watch('src/js/modules/*.js', ['modules_scripts']);
    gulp.watch('src/js/admin/*.js', ['admin_scripts']);
    // Watch .js files
    gulp.watch('src/js/vendor/*', ['vendorScripts']);
    gulp.watch('src/sass/vendor/*', ['vendorScripts']);
    // Watch image files
    gulp.watch('src/images/**/*', ['images']);
});

gulp.task('all', function () {
    gulp.src('./src/sass/**/*.scss')
        .pipe($.sass().on('error', $.sass.logError))
        .pipe($.autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4'))
        .pipe($.cleanCss())
        .pipe(gulp.dest('public/css'));
});

gulp.task('default', function () {
    gulp.start(
        'styles',
        'vendorScripts',
        'admin_scripts',
        'modules_scripts',
        'images',
        'browser-sync',
        'watch'
    );
});