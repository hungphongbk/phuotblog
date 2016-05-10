$ = require 'jquery'

module.exports = (animationName)->
  animationEnd = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend'
  $(@).addClass "animated #{animationName}"
  .one animationEnd, ->
    $(@).removeClass "animated #{animationName}"