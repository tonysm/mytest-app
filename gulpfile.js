var gulp = require('gulp'),
    sass = require('gulp-ruby-sass'),
    autoprefix = require('gulp-autoprefixer'),
    notify = require('gulp-notify'),
    bower = require('gulp-bower');

var config = {
    sassPath: './resources/sass',
    bowerDir: './bower_components'
};

// runs bower install automatically during the "gulp" command
gulp.task('bower', function() {
    return bower()
        .pipe(gulp.dest(config.bowerDir));
});

// takes whatever is in /bower_components/fontawesome/fonts and places
// at public/fonts
gulp.task('icons', function() {
   return gulp.src(config.bowerDir + '/fontawesome/fonts/**.*')
       .pipe(gulp.dest('./public/fonts'));
});

// setting up sass and linking bootstrap and fontawesome in
// our path, so our sass files can access
gulp.task('css', function() {
    return gulp.src(config.sassPath + '/styles.scss')
        .pipe(sass({
            style: 'compressed',
            loadPath: [
                './resources/sass',
                config.bowerDir + '/bootstrap-sass-official/assets/stylesheets',
                config.bowerDir + '/fontawesome/scss'
            ]
        }))
        .on("error", notify.onError(function (error) {
            return "Error:" + error.message;
        }))
        .pipe(autoprefix('last 2 version'))
        .pipe(gulp.dest('./public/css'));
});

// rerun the task when file changes
gulp.task('watch', function() {
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
});

gulp.task('default', ['bower', 'icons', 'css']);