del            = require 'del'
gulp           = require 'gulp'
source         = require 'vinyl-source-stream'
buffer         = require 'vinyl-buffer'
plugins        = require('gulp-load-plugins')()
browserify     = require 'browserify'
browserSync    = require 'browser-sync'
path           = require 'path'

paths =
  srcDir       : 'src'
  srcLib       : 'src/lib'
  srcStyles    : 'src/sass'
  srcAssets    : 'src/assets'
  srcImages    : 'src/images'
  srcScripts   : 'src/scripts'
  srcPureJs    : 'src/js'
  srcPrefabDir : 'src/prefab'

  distDir     : 'dist'
  distLib     : 'dist/lib'
  distStyles  : 'dist/css'
  distAssets  : 'dist/assets'
  distFonts   : 'dist/fonts'
  distScripts : 'dist/scripts'

gulp.task 'clean', (cb) ->
  del [paths.distDir], cb

gulp.task 'copyResource', ()->
  externals=[
    'src/vendor/bootstrap/dist/fonts/**/*',
    'src/vendor/flexslider/fonts/**/*',
    'src/vendor/font-awesome/fonts/**/*',
    'src/fonts/**/*'
  ]
  gulp.src externals
  .pipe gulp.dest paths.distFonts

gulp.task 'copyCss', () ->
  externals=[
    'src/vendor/bootstrap/dist/css/bootstrap.css',
    'src/vendor/flexslider/flexslider.css',
    'src/vendor/animate.css/animate.css',
    'src/vendor/font-awesome/css/font-awesome.css',
    'src/vendor/jquery.rateit/scripts/rateit.css'
  ];
  gulp.src externals
  .pipe plugins.concat 'vendor.css'
  .pipe plugins.replace "'fonts", "'../fonts"
  .pipe gulp.dest paths.distStyles

gulp.task 'copyJs', ()->
  gulp.src "#{paths.srcPureJs}/*.js"
  .pipe plugins.uglify()
  .pipe gulp.dest paths.distScripts

gulp.task 'style', ()->
  gulp.src "#{paths.srcStyles}/*.scss"
    .pipe plugins.compass
      project: __dirname
      css: 'dist/css'
      sass: 'src/sass'
      image: 'src/images'
      require: 'sass_inline_svg'
    .pipe plugins.cssimport()
    .pipe plugins.cssmin()
    .pipe gulp.dest paths.distStyles
  
gulp.task 'coffeeify', ()->
  b = browserify
    entries: "#{paths.srcScripts}/main.coffee"
    debug: off
    transform: ['coffeeify']
    extensions: ['coffee']

  b.bundle()
  .pipe source "#{paths.srcScripts}/main.coffee"
  .pipe buffer()
#  .pipe plugins.uglify()
  .pipe plugins.rename 'main.js'
  .pipe gulp.dest "#{paths.distScripts}"

gulp.task 'watch', ()->
  bs = browserSync.create()

  deleteFileFromBuildDir = (event, path) ->
    return  unless event is 'unlink' or event is 'unlinkDir'
    # replacing app folder with build
    path = path.replace "#{paths.srcDir}/", "#{paths.distDir}/"
    # deleting the file from build directory
    del [path], ->

  watchFiles = (path, gulpTask) ->

    bs.watch path, (event, file) ->
      gulp.start gulpTask
      deleteFileFromBuildDir event, file

  watchFiles ["#{paths.srcStyles}/**", "#{paths.srcImages}/**"],        'style'
  watchFiles "#{paths.srcScripts}/**",                                  'coffeeify'
  watchFiles "#{paths.srcPureJs}/**",                                   'copyJs'

gulp.task 'build', ['coffeeify', 'copyResource', 'copyCss', 'copyJs', 'style', 'watch'], ->
  gulp
    .src "#{paths.distDir}/**/*"
    .pipe plugins.size
      title : 'build'
      gzip  : off
    .pipe plugins.size
      title : 'build'
      gzip  : on

gulp.task 'default', ['clean'], ->
  gulp.start 'build'