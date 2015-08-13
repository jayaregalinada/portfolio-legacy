window._j49 = angular.module('J46', ['ui.bootstrap', 'ngAnimate', 'ui.router', 'bootstrapLightbox', 'LocalStorageModule', 'ngMessages', 'uiGmapgoogle-maps', 'wu.masonry']);

window._j49.config(function($interpolateProvider, $animateProvider, $httpProvider, LightboxProvider, localStorageServiceProvider, cfpLoadingBarProvider) {
  $interpolateProvider.startSymbol('{#');
  $interpolateProvider.endSymbol('#}');
  LightboxProvider.getImageUrl = function(image) {
    return image.sizes[0].url;
  };
  LightboxProvider.getImageCaption = function(image) {
    return image.caption;
  };
  LightboxProvider.calculateModalDimensions = function(dimensions) {
    var width;
    width = Math.max(400, dimensions.imageDisplayWidth - 8);
    if (width >= dimensions.windowWidth - 20 || dimensions.windowWidth < 768) {
      width = 'auto';
    }
    return {
      'width': width,
      'height': 'auto'
    };
  };
  LightboxProvider.templateUrl = 'views/lightbox.html';
  localStorageServiceProvider.setPrefix('jag');
  $animateProvider.classNameFilter(/carousel|animate/);
  $httpProvider.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
  cfpLoadingBarProvider.includeSpinner = false;
});

window._j49.run(function($rootScope, $state, $stateParams, $log, $timeout) {
  $rootScope.$state = $state;
  $rootScope.$stateParams = $stateParams;
  $rootScope.$on('errorOccured', function() {
    $('body').addClass('error-occured');
  });
  $rootScope.$on('cfpLoadingBar:loading', function(loading) {
    $log.debug('cfpLoadingBar:loading', loading);
    $('body').removeClass('error-occured');
  });
  $rootScope.$on('cfpLoadingBar:started', function(started) {
    $log.debug('cfpLoadingBar:started', started);
    $('body').removeClass('error-occured');
  });
  $rootScope.$on('cfpLoadingBar:completed', function(completed) {
    $log.debug('cfpLoadingBar:completed', completed);
  });
});

angular.element(document).ready(function() {
  angular.bootstrap(document, ['J46']);
  window._glitch = new GlitchFX('glitch_canvas', '/images/logo.png');
  $('[data-toggle="tooltip"]').tooltip({
    container: 'body'
  });
  $('[data-toggle="popover"]').popover();
});
