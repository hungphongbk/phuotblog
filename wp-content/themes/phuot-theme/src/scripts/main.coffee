require './inc/preprocess.coffee'
plugins = require './jqPlugins/index.coffee'
plugins_prefix = 'myplugin_'


$(window).load ->
  $('.flexslider').flexslider
    directionNav: false

  $.each plugins, (plName, pl)->
    if pl.name? and pl.name.length > 0
      $.fn[plName] = (options)->
        @each ->
          if !$.data(@, "#{plugins_prefix}#{plName}")
            $.data @, "#{plugins_prefix}#{plName}", new pl(@, options)
    else
      $.fn[plName] = pl

  console.log $.fn

  $('.gallery-carousel').GalleryCarousel()
  $masonryContainer = $('.masonry-container')
  $masonryContainer.WpMasonry
    debug: true

  (->
    trivials = $('#secondary').contents().filter ->
      @nodeType = 3 and @nodeName == '#text'
    $.each trivials, ->
      $(@).remove())()