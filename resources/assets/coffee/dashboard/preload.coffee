# window._dashboard = angular.module 'd4sh', [
#   'ui.bootstrap'
#   'ngAnimate'
#   'ui.router'
#   'bootstrapLightbox'
#   'LocalStorageModule'
#   'ngMessages'
#   'uiGmapgoogle-maps'
#   'wu.masonry'
#   'textAngular'
#   ]

# window._dashboard.config ($interpolateProvider, $animateProvider, $httpProvider, LightboxProvider, localStorageServiceProvider)->

#   $interpolateProvider.startSymbol '{#'
#   $interpolateProvider.endSymbol '#}'

#   LightboxProvider.getImageUrl = ( image )->
#     image.sizes[0].url

#   LightboxProvider.getImageCaption = ( image )->
#     image.caption

#   LightboxProvider.calculateModalDimensions = ( dimensions )->
#     width = Math.max 400, dimensions.imageDisplayWidth - 8

#     if width >= dimensions.windowWidth - 20 or dimensions.windowWidth < 768
#         width = 'auto'
#     {
#         'width': width
#         'height': 'auto'
#     }

#   LightboxProvider.templateUrl = 'views/lightbox.html'

#   localStorageServiceProvider.setPrefix( 'dashboard' )

#   $animateProvider.classNameFilter /carousel|animate/

#   $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

#   return

# window._dashboard.run ($rootScope, $state, $stateParams)->

#   $rootScope.$state = $state
#   $rootScope.$stateParams = $stateParams

#   return

# angular.element(document).ready ->
#   angular.bootstrap(document, ['d4sh'])

#   $( '[data-toggle="tooltip"]' ).tooltip(
#     container: 'body'
#   )

#   $( '[data-toggle="popover"]' ).popover()

#   return
#
$ ->
  $grid = $('.grid').masonry
    columnWidth: '.grid-sizer'
    percentPosition: true
    itemSelector: '.grid-item'
    gutter: 10

  $grid.imagesLoaded().progress ->
    $grid.masonry 'layout'

    return

  return