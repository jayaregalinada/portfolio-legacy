# canvas = document.getElementById('glitch_canvas')
# context = canvas.getContext('2d')
# img = new Image
# w = undefined
# h = undefined
# offset = undefined
# glitchInterval = undefined
# img.src = '/images/logo.png'

# img.onload = ->
#   init()
#   window.onresize = init

#   return

# init = ->
#   clearInterval glitchInterval
#   canvas.width = w = window.innerWidth
#   offset = w * .1
#   canvas.height = h = ~ ~(175 * (w - (offset * 2)) / img.width)
#   glitchInterval = setInterval((->
#     clear()
#     context.drawImage img, 0, 110, img.width, 175, offset, 0, w - (offset * 2), h
#     setTimeout glitchImg, randInt(250, 1000)
#     return
#   ), 500)
#   return

# clear = ->
#   context.rect 0, 0, w, h
#   context.fill()
#   return

# glitchImg = ->
#   i = 0
#   while i < randInt(1, 13)
#     x = Math.random() * w
#     y = Math.random() * h
#     spliceWidth = w - x
#     spliceHeight = randInt(5, h / 3)
#     context.drawImage canvas, 0, y, spliceWidth, spliceHeight, x, y, spliceWidth, spliceHeight
#     context.drawImage canvas, spliceWidth, y, x, spliceHeight, 0, y, x, spliceHeight
#     i++
#   return

# randInt = (a, b) ->
#   ~ ~(Math.random() * (b - a) + a)

# ---
# generated by js2coffee 2.1.0