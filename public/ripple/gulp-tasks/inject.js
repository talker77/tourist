'use strict'
var gulp = require('gulp');
var injectPartials = require('gulp-inject-partials');
var inject = require('gulp-inject');
var rename = require('gulp-rename');
var prettify = require('gulp-prettify');
var replace = require('gulp-replace');
var runSequence = require('run-sequence');



/*sequence for injecting partials and replacing paths*/
gulp.task('inject', function () {
    runSequence('injectPartial', 'injectAssets', 'html-beautify', 'replacePath');
});



/* inject partials like sidebar and navbar */
gulp.task('injectPartial', function () {
    return gulp.src(["./src/**/*.html", "!./dist/**/*.html", "!./node_modules/**/*.html"], {
            base: "./"
        })
        .pipe(injectPartials())
        .pipe(gulp.dest("."));
});


gulp.task('injectAssets', function () {
    return gulp.src('./**/*.html')
        .pipe(inject(gulp.src(['./vendors/js/core.js', './vendors/js/vendor.addons.js', './vendors/iconfonts/mdi/css/materialdesignicons.css', './vendors/css/vendor.addons.css'], {
            read: false
        }), {
            name: 'plugins',
            relative: true
        }))
        .pipe(inject(gulp.src(['./css/*.css', './js/template.js'], {
            read: false
        }), {
            relative: true
        }))
        .pipe(gulp.dest('.'));
});



/*replace image path and linking after injection*/
gulp.task('replacePath', function () {
    gulp.src('src/pages/*/*.html', {
            base: "./"
        })
        .pipe(replace('src="images/', 'src="../../images/'))
        .pipe(replace('href="pages/', 'href="../../pages/'))
        .pipe(replace('href="docs/', 'href="../../docs/'))
        .pipe(replace('href="index.html"', 'href="../../index.html"'))
        .pipe(gulp.dest('.'));
    gulp.src('src/pages/*.html', {
            base: "./"
        })
        .pipe(replace('src="images/', 'src="../images/'))
        .pipe(replace('"pages/', '"../pages/'))
        .pipe(replace('href="index.html"', 'href="../index.html"'))
        .pipe(gulp.dest('.'));
});


gulp.task('html-beautify', function () {
    return gulp.src('./**/*.html')
        .pipe(prettify({
            unformatted: ['pre', 'code', 'textarea']
        }))
        .pipe(gulp.dest(function (file) {
            return file.base;
        }));
});