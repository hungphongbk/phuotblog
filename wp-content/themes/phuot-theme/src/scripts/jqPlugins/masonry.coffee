require 'imagesloaded'
$ = require 'jquery'
BasePlugin = require './basePlugin.coffee'
jqBridget = require 'jquery-bridget'
Masonry = require 'masonry-layout'
jqBridget 'masonry', Masonry, $

class WpMasonry extends BasePlugin

  constructor: (element, options)->
    super()

    $.extend @options,
      itemClass: '.masonry-item'
      imgWrapperClass: '.overlay',
      options
    # Extend user options with default

    @$element = $ element

    @init()

  init: ->
    console.log @options
    @log "Plugin loaded"
    @$element.imagesLoaded()
    .always allImagesLoaded.bind @
    .progress oneImageLoaded.bind @

  allImagesLoaded= ->
    @log "All of masonry images has been loaded :)"
    @$element.masonry
      columnWidth: @options.itemClass
      itemSelector: @options.itemClass

  oneImageLoaded= (_, image)->
    if not image.isLoaded
      @log "#{image.img.src} broken :("
      return

    $image = $ image.img
    $imageWrapper = $image.closest @options.imgWrapperClass
    wrapperRatio = $imageWrapper.width() / $imageWrapper.height()
    imgRatio = $image.width() / $image.height()
    return if isNaN wrapperRatio
    if wrapperRatio>imgRatio
      $image.width '100%'


  log: (message)->
    super message

module.exports = WpMasonry