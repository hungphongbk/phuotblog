class BasePlugin
  constructor: ->
    @options =
      debug: false

  log: (message)->
    if @options.debug
      console.log "[#{@constructor.name}]: #{message}"
    return

module.exports = BasePlugin