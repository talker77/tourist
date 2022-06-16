'use strict'
var gulp = require('gulp');
const del = require('del');
var merge = require('merge-stream');
var concat = require('gulp-concat');
var htmlmin = require('gulp-htmlmin');
var cleanCSS = require('gulp-clean-css');
var runSequence = require('run-sequence');
var uglify = require('gulp-uglify');
var replace = require('gulp-replace');
var htmlreplace = require('gulp-html-replace');
const imagemin = require('gulp-imagemin');

var paths = {
    src: 'src/**/*',
    srcHTML: ['src/**/*.html', '!src/vendors/**/*.html', '!src/partials/*.html'],
    srcCSS: 'src/css/**/*.css',
    srcJS: ['src/js/**/*.js'],
    srcJson: ['src/js/**/*.json'],
    srcImages: [
        'src/images/**/*.png',
        'src/images/**/*.jpg',
        'src/images/**/*.jpeg',
        'src/images/**/*.svg',
        'src/images/**/*.ico'
    ],
    srcFonts: [
        'src/fonts/**/*.eot',
        'src/fonts/**/*.svg',
        'src/fonts/**/*.ttf',
        'src/fonts/**/*.woff',
        'src/fonts/**/*.woff2'
    ],
    srcVendorFiles: [
        'src/vendors/**/*.eot',
        'src/vendors/**/*.svg',
        'src/vendors/**/*.ttf',
        'src/vendors/**/*.woff',
        'src/vendors/**/*.woff2',
        'src/vendors/**/*.png',
        'src/vendors/**/*.jpg',
        'src/vendors/**/*.jpeg',
        'src/vendors/**/*.svg',
        'src/vendors/**/*.json'
    ],
    srcVendorjs: 'src/vendors/**/*.js',
    srcVendorsCSS: 'src/vendors/**/*.css',


    dist: 'preview/',
    distHTML: 'preview/',
    distCSS: 'preview/css/',
    distJS: 'preview/js/',
    distImages: 'preview/images/',
    distFonts: 'preview/fonts/',
    distVendors: 'preview/vendors/',
};


gulp.task('build', function () {
    del.sync([paths.dist + '**']);
    runSequence('minifyHTML', 'minifyCSS', 'minifyJS', 'copyJsonFiles', 'copyImageFiles', 'copyFontsFiles', 'copyVendorFiles', 'copyVendorCSS', 'copyVendorJS', 'replaceScriptPath');
});



gulp.task('minifyHTML', function () {
    return gulp.src(paths.srcHTML)
        .pipe(htmlreplace({
            js: 'js/script.js'
        }))
        .pipe(htmlmin({
            collapseWhitespace: true,
        }))
        .pipe(gulp.dest(paths.dist));
});

gulp.task('replaceScriptPath', function () {
    gulp.src(paths.dist + 'pages/*/*.html', {
            base: "./"
        })
        .pipe(replace('src="js/', 'src="../../js/'))
        .pipe(gulp.dest('.'));
    gulp.src(paths.dist + 'pages/*.html', {
            base: "./"
        })
        .pipe(replace('src="js/', 'src="../js/'))
        .pipe(gulp.dest('.'));
});

gulp.task('minifyCSS', () => {
    return gulp.src(paths.srcCSS)
        .pipe(cleanCSS({
            compatibility: 'ie8'
        }))
        .pipe(gulp.dest(paths.distCSS));
});

gulp.task('minifyJS', function (cb) {
    return gulp.src(paths.srcJS)
        .pipe(concat('script.js'))
        .pipe(uglify())
        .pipe(gulp.dest(paths.distJS));
});

gulp.task('copyJsonFiles', function (cb) {
    return gulp.src(paths.srcJson)
        .pipe(gulp.dest(paths.distJS));
});

gulp.task('copyImageFiles', function () {
    return gulp.src(paths.srcImages)
        .pipe(imagemin())
        .pipe(gulp.dest(paths.distImages));
});

gulp.task('copyFontsFiles', function () {
    return gulp.src(paths.srcFonts)
        .pipe(gulp.dest(paths.distFonts));
});

gulp.task('copyVendorFiles', function () {
    return gulp.src(paths.srcVendorFiles)
        .pipe(imagemin())
        .pipe(gulp.dest(paths.distVendors));
});

gulp.task('copyVendorCSS', function () {
    return gulp.src(paths.srcVendorsCSS)
        // .pipe(cleanCSS({
        //     compatibility: 'ie8'
        // }))
        .pipe(gulp.dest(paths.distVendors));
});

gulp.task('copyVendorJS', function () {
    return gulp.src(paths.srcVendorjs)
        .pipe(uglify())
        .pipe(gulp.dest(paths.distVendors));
});