gulp.task('script', function() {
  var sources = browserify({
    entries: 'webroot/js/app.js',
    debug: true
  })
  .transform(babelify.configure());
 
  return sources.bundle()
    .pipe(vinylSourceStream('app.min.js'))
    .pipe(vinylBuffer())
    // Do stuff to the output file
    .pipe(gulp.dest('webroot/js/build/'));
});
