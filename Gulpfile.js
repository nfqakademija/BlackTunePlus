'use strict';

var gulp    = require('gulp');
var sass    = require('gulp-sass');
var concat  = require('gulp-concat');
var uglify  = require('gulp-uglify');
var watch = require('gulp-watch');
var util = require('gulp-util');
const babel = require('gulp-babel');

var dir = {
    assets: './src/AppBundle/Resources/',
    dist: './web/',
    npm: './node_modules/',
};

gulp.task('sass', function() {
    gulp.src(dir.assets + 'style/main.scss')
        .pipe(sass({ outputStyle: 'compressed' }).on('error', sass.logError))
        .pipe(concat('style.css'))
        .pipe(gulp.dest(dir.dist + 'css'));
});

gulp.task('scripts', function() {
    gulp.src([
            //Third party assets
            dir.npm + 'jquery/dist/jquery.min.js',
            dir.npm + 'bootstrap-sass/assets/javascripts/bootstrap.min.js',
            dir.npm + 'slick-carousel/slick/slick.js',
            // Main JS file
            dir.assets + 'scripts/main.js'
        ])
        .pipe(concat('script.js'))
        .pipe(uglify().on('error', util.log))
        .pipe(gulp.dest(dir.dist + 'js'));
});

gulp.task('images', function() {
    gulp.src([
            dir.assets + 'images/**'
        ])
        .pipe(gulp.dest(dir.dist + 'images'));
});

gulp.task('fonts', function() {
    gulp.src([
        dir.npm + 'bootstrap-sass/assets/fonts/**'
        ])
        .pipe(gulp.dest(dir.dist + 'fonts'));
});

// gulp.task('watch', function() {
//     gulp.watch(dir.assets + 'scripts/main.js', ['scripts']);
//     gulp.watch(dir.assets + 'styles/main.scss', ['sass']);
// });

gulp.task('default', ['sass', 'scripts', 'fonts', 'images']);
