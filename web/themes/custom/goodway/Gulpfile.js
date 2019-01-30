var gulp = require('gulp');
var aluminumCapsule = require('aluminum-capsule');
var exec = require('child_process').exec

/**
 * Load aluminum-capsule which will handle our Gulp tasks.
 *
 * Use config.json to override configuration, and create your own tasks here as you see fit.
 */
aluminumCapsule.gulpTasks(gulp);

gulp.task('lando:start', function (cb) {
  exec('/usr/local/bin/lando start', function (err, stdout) {
    console.log(stdout);
    cb(err);
  });
});

gulp.task('lando:stop', function (cb) {
  exec('/usr/local/bin/lando stop', function (err, stdout) {
    console.log(stdout);
    cb(err);
  });
});
