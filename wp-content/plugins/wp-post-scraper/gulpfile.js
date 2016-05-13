/**
 * Created by hungphongbk on 5/13/16.
 */
var gulp = require('gulp'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat');

gulp.task('js', function(){
    var js = [
        'assets/src/index.js'
    ];

    return gulp.src(js)
        .pipe(concat('main.js'))
        .pipe(uglify())
        .pipe(gulp.dest('assets/build'));
});

gulp.task('default', ['js']);