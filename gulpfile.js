var gulp = require('gulp');
var imageResize = require('gulp-image-resize');

gulp.task('default', function () {
  gulp.src('assets/**/*.jpg')
    .pipe(imageResize({
      width : 300,
      height : 300,
      upscale : true
    }))
    .pipe(gulp.dest('website/public/assets'));
});