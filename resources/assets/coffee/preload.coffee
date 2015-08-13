window._j49 = angular.module 'J46', [
  'ui.bootstrap'
  'ngAnimate'
  'ui.router'
  'bootstrapLightbox'
  'LocalStorageModule'
  'ngMessages'
  'uiGmapgoogle-maps'
  'wu.masonry'
  ]

window._j49.config ($interpolateProvider, $animateProvider, $httpProvider, LightboxProvider, localStorageServiceProvider, cfpLoadingBarProvider)->

  $interpolateProvider.startSymbol '{#'
  $interpolateProvider.endSymbol '#}'

  LightboxProvider.getImageUrl = ( image )->
    image.sizes[0].url

  LightboxProvider.getImageCaption = ( image )->
    image.caption

  LightboxProvider.calculateModalDimensions = ( dimensions )->
    width = Math.max 400, dimensions.imageDisplayWidth - 8

    if width >= dimensions.windowWidth - 20 or dimensions.windowWidth < 768
        width = 'auto'
    {
        'width': width
        'height': 'auto'
    }

  LightboxProvider.templateUrl = 'views/lightbox.html'

  localStorageServiceProvider.setPrefix( 'jag' )

  $animateProvider.classNameFilter /carousel|animate/

  $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest"

  cfpLoadingBarProvider.includeSpinner = false

  return

window._j49.run ($rootScope, $state, $stateParams, $log, $timeout)->

  $rootScope.$state = $state
  $rootScope.$stateParams = $stateParams

  $rootScope.$on 'errorOccured', ->
    $('body').addClass 'error-occured'

    return

  $rootScope.$on 'cfpLoadingBar:loading', (loading)->
    $log.debug 'cfpLoadingBar:loading', loading
    $('body').removeClass 'error-occured'

    return

  $rootScope.$on 'cfpLoadingBar:started', (started)->
    $log.debug 'cfpLoadingBar:started', started
    $('body').removeClass 'error-occured'

    return

  $rootScope.$on 'cfpLoadingBar:completed', (completed)->
    $log.debug 'cfpLoadingBar:completed', completed

    return


  return

angular.element(document).ready ->
  angular.bootstrap(document, ['J46'])

  window._glitch = new GlitchFX('glitch_canvas', '/images/logo.png')

  $( '[data-toggle="tooltip"]' ).tooltip(
    container: 'body'
  )

  $( '[data-toggle="popover"]' ).popover()

  return