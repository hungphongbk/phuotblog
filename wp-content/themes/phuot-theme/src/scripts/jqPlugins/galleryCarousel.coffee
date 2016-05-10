$ = require 'jquery'
animateCss = require './animateCss.coffee'

class GalleryCarousel
  constructor:(element, options)->
    @$element = $(element)
    if not $.fn['AnimateCss']
      $.fn['AnimateCss'] = animateCss

    # skeleton elements
    @init()
    @modifySlideSizes()
    @activate 0

  init: ->
    _this = @
    @$wrapper = @$element.parent()
    @$slides = @$element.find('.slides')
    @$slides = $(@$slides).children()
    @$navigations = @$element.find('.navigations')[0]
    @$navigations = $(@$navigations).children()

    @count = @$slides.children().length
    @slideHeight = $(@$slides[0]).outerHeight()
    @slideWidth = $(@$slides[0]).outerWidth()
    @slideRatio = @slideWidth / @slideHeight

    @current = 0
    @$prevSlide = null
    @$prevNav = null

    $(@$navigations).each (i)->
      $(@).data 'index',i
      $(@).click ->
        _this.activate $(@).data 'index'

  modifySlideSizes: ->
    @$slides.each ->
      $img = $(@).children()[0]
      height = $($img).height()
      width = $($img).width()
      ratio = width/height
      if(ratio>@slideRatio)
        $($img).addClass 'prefer-height'
      else
        $($img).addClass 'prefer-width'

  activate: (index)->
    @current = index
    if @$prevSlide?
      $(@$prevSlide).removeClass 'active'
      $(@$prevNav).removeClass 'active'

    $slide = $(@$slides[@current])
    $nav = $(@$navigations[@current])
    $($slide).addClass 'active'
    $($nav).addClass 'active'

    @$prevSlide = $slide
    @$prevNav = $nav

module.exports = GalleryCarousel