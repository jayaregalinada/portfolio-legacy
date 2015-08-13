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

window._j49.config(function($stateProvider, $urlRouterProvider) {
  var $path;
  $path = window.location.origin + window.location.pathname;
  $urlRouterProvider.otherwise('/');
  $stateProvider.state('index', {
    url: '/',
    controller: 'IndexController',
    views: {
      'projects': {
        templateUrl: $path + '/views/index.html',
        controller: 'ProjectController'
      }
    }
  }).state('project', {
    abstract: true,
    url: '/project',
    controller: 'ProjectController',
    template: '<ui-view class="projects index-projects animate" />'
  }).state('project.view', {
    parent: 'project',
    url: '/:productId',
    templateUrl: $path + '/views/project_view.html',
    controller: function($scope, $stateParams) {
      $scope.view($stateParams.productId);
    }
  });
});

_j49.controller('IndexController', function($scope, $state, $stateParams, $rootScope, $window, $log) {
  var _r;
  _r = $window._route;
  $scope.checkingState = function() {
    $log.log('Checking $state...', $state);
    $log.log('Checking location...', $window.location);
    $log.log('Checking $stateParams', $stateParams);
  };
  $scope.goToProjects = function() {};
  $scope.checkingState();
});

_j49.controller('ProjectController', function($scope, $http, $window, $log, $state, $stateParams, $req, $helpers, localStorageService, $timeout, $rootScope) {
  var _r;
  $scope.project = {};
  $scope.projects = [];
  $scope.condition = {};
  _r = $window._route;
  $scope.status = $helpers.getAllDefaultStatus();
  $scope.getAllTimeout = null;
  $scope.getAllNextPageDelayTime = 2000;
  $scope.checking = function() {
    $log.info('Checking $state', $state);
    $scope.switches($state.current);
  };
  $scope.switches = function(currentState) {
    switch (currentState.name) {
      case 'index':
        $scope.gettingAll();
        return;
      default:
        return;
    }
  };
  $scope.pushToProjects = function(data) {
    angular.forEach(data, function(val, key) {
      $scope.projects.push(val);
    });
  };
  $scope.get = function(id) {
    var url;
    url = _r['project.show'].replace('{project}', id);
    $http.get(url).success(function(successData) {
      $scope.project = successData;
      $log.log(successData);
    });
  };
  $scope.gettingAll = function() {
    var prjct;
    $scope.projects = [];
    $scope.status = $helpers.statusWhenGettingAll();
    prjct = ['project_page', 'project_paginate_done', 'project_paginate_interrupted'];
    angular.forEach(prjct, function(v) {
      localStorageService.remove(v);
    });
    $timeout(function() {
      $scope.getAll(1);
    }, 1500);
  };
  $scope.getAll = function(pageNumber) {
    var url;
    url = _r['project.index'];
    $rootScope.$broadcast('projects:all', {
      page: pageNumber
    });
    $scope.status = $helpers.statusWhenGetAll();
    $req._paginate(pageNumber, url).success(function(successData) {
      $log.log('ProjectController@getAll', successData);
      $rootScope.$broadcast('projects:all:success');
      $scope.status.error = false;
      localStorageService.set('project_page', successData.success.data.current_page);
      if (Boolean(successData.success.data.next_page_url)) {
        if ($state.is('index')) {
          $scope.getAllTimeout = $timeout(function() {
            $scope.getAll(successData.success.data.current_page + 1);
          }, $scope.getAllNextPageDelayTime);
        } else {
          localStorageService.set('project_paginate_interrupted', true);
        }
      } else {
        $rootScope.$broadcast('projects:all:complete');
        $scope.status.loading = false;
        localStorageService.set('project_paginate_done', true);
      }
    }).error(function(err) {
      $log.error('ProjectController@getAll::error', errorData);
      $rootScope.$broadcast('projects:all:error');
      $rootScope.$broadcast('errorOccured');
      $scope.status = $helpers.statusWhenError(errorData.error.message);
    }).then(function(thenData) {
      $scope.pushToProjects(thenData.data.success.data.data);
      $scope.status.loadingFirstTime = false;
    });
  };
  $scope.view = function(productId) {
    var url;
    url = _r['project.show'].replace('{project}', productId);
    $http.get(url).success(function(successData) {
      $log.log(successData);
      $scope.project = successData.success.data;
    }).error(function(err) {
      $log.error(errData);
    });
  };
  $scope.checking();
});

_j49.factory('$helpers', function($rootScope) {
  var _h;
  _h = {};
  _h.getAllDefaultStatus = function() {
    return {
      loading: false,
      error: false,
      errorMessage: null,
      loadingFirstTime: false
    };
  };
  _h.getAllDefaultTimeout = function() {
    return {
      gettingAll: null,
      nextPage: 3000
    };
  };
  _h.statusWhenGettingAll = function() {
    return {
      loadingFirstTime: true,
      error: false
    };
  };
  _h.statusWhenGetAll = function() {
    return {
      loading: true,
      error: false
    };
  };
  _h.statusWhenSuccess = function() {
    return {
      error: false
    };
  };
  _h.statusWhenNoMoreNextPage = function() {
    return {
      loading: false
    };
  };
  _h.statusWhenError = function(errorMessage) {
    return {
      error: true,
      loading: false,
      errorMessage: errorMessage
    };
  };
  _h.statusWhenComplete = function() {
    return {
      loadingFirstTime: false
    };
  };
  return _h;
});

_j49.factory('$req', function($http) {
  var _r;
  _r = {};
  _r._paginate = function(pageNumber, url, method) {
    if (angular.isObject(pageNumber)) {
      url = pageNumber.url;
      pageNumber = pageNumber.page;
      method = pageNumber.method;
    }
    return $http({
      url: url,
      method: method ? method : 'GET',
      params: {
        page: pageNumber
      }
    });
  };
  _r._post = function(url, data, params, method) {
    if (angular.isObject(url)) {
      url = url.url;
      data = url.data;
      params = url.params;
      method = url.method;
    }
    return $http({
      url: url,
      data: data,
      params: params,
      method: method ? method : 'POST'
    });
  };
  _r._delete = function(url, data, params) {
    if (angular.isObject(url)) {
      url = url.url;
      data = url.data;
      params = url.params;
    }
    return _r._post(url, data, params, 'DELETE');
  };
  _r._patch = function(url, data, params) {
    if (angular.isObject(url)) {
      url = url.url;
      data = url.data;
      params = url.params;
    }
    return _r._post(url, data, params, 'PATCH');
  };
  _r._put = function(url, data, params) {
    if (angular.isObject(url)) {
      url = url.url;
      data = url.data;
      params = url.params;
    }
    return _r.post(url, data, params, 'PUT');
  };
  _r._get = function(url, params) {
    if (angular.isObject(url)) {
      url = url.url;
      params = url.params;
    }
    return $http({
      url: url,
      params: params,
      method: 'GET'
    });
  };
  return _r;
});

var GlitchFX;

GlitchFX = (function() {
  'use strict';
  GlitchFX.canvas;

  GlitchFX.context;

  GlitchFX.img;

  GlitchFX.offset = void 0;

  GlitchFX.w = void 0;

  GlitchFX.h = void 0;

  GlitchFX.glitchInterval = void 0;

  function GlitchFX(id, src) {
    id = id ? id : 'glitch_canvas';
    src = src ? src : '/images/logo.png';
    this.img = new Image;
    this.img.src = src;
    this.canvas = document.getElementById(id);
    this.context = this.canvas.getContext('2d');
    this.img.onload = (function(_this) {
      return function() {
        _this.glitching();
      };
    })(this);
    return;
  }

  GlitchFX.prototype.glitching = function() {
    this.canvas.width = this.w = $(window).width();
    this.offset = this.w * .1;
    this.canvas.height = this.h = ~~(175 * (this.w - (this.offset * 2)) / this.img.width);
    $(window).resize((function(_this) {
      return function() {
        _this.canvas.width = _this.w = $(window).width();
        _this.offset = _this.w * .1;
        _this.canvas.height = _this.h = ~~(175 * (_this.w - (_this.offset * 2)) / _this.img.width);
      };
    })(this));
    clearInterval(this.glitchInterval);
    this.glitchInterval = setInterval((function(_this) {
      return function() {
        _this.clear();
        _this.context.drawImage(_this.img, 0, 110, _this.img.width, 175, _this.offset, 0, _this.w - (_this.offset * 2), _this.h);
        setTimeout(function() {
          _this.glitchImg(_this.context, _this.canvas);
        }, _this.randInt(250, 1000));
      };
    })(this), 500);
  };

  GlitchFX.prototype.glitchImg = function(context, canvas) {
    var a, b, i, spliceHeight, spliceWidth, x, y;
    i = 0;
    a = this.randInt(1, 13);
    b = this.randInt(5, this.h / 3);
    while (i < a) {
      x = Math.random() * this.w;
      y = Math.random() * this.h;
      spliceWidth = this.w - x;
      spliceHeight = b;
      context.drawImage(canvas, 0, y, spliceWidth, spliceHeight, x, y, spliceWidth, spliceHeight);
      context.drawImage(canvas, spliceWidth, y, x, spliceHeight, 0, y, x, spliceHeight);
      i++;
    }
  };

  GlitchFX.prototype.randInt = function(a, b) {
    return ~~(Math.random() * (b - a) + a);
  };

  GlitchFX.prototype.clear = function() {
    this.context.rect(0, 0, this.w, this.h);
    this.context.fill();
  };

  return GlitchFX;

})();




/*
* Inspired by:
* http://designedbythomas.co.uk/blog/how-detect-width-web-browser-using-jquery
*
* This script is ideal for getting specific class depending on device width
* for enhanced theming. Media queries are fine in most cases but sometimes
* you want to target a specific JQuery call based on width. This will work
* for that. Be sure to put it first in your script file. Note that you could
* also target the body class instead of 'html' as well.
* Modify as needed
 */
(function($) {
  $(document).ready(function() {
    var current_width;
    current_width = $(window).width();
    if (current_width < 481) {
      $('html').addClass('m320').removeClass('m768').removeClass('desktop').removeClass('m480');
    } else if (current_width < 739) {
      $('html').addClass('m768').removeClass('desktop').removeClass('m320').removeClass('tablet');
    } else if (current_width < 970) {
      $('html').addClass('tablet').removeClass('desktop').removeClass('m320').removeClass('m768');
    } else if (current_width > 971) {
      $('html').addClass('desktop').removeClass('m320').removeClass('m768').removeClass('tablet');
    }
    if (current_width < 650) {
      $('html').addClass('mobile-menu').removeClass('desktop-menu');
    }
    if (current_width > 651) {
      $('html').addClass('desktop-menu').removeClass('mobile-menu');
    }
  });
  $(window).resize(function() {
    var current_width;
    current_width = $(window).width();
    if (current_width < 481) {
      $('html').addClass('m320').removeClass('m768').removeClass('desktop').removeClass('tablet');
    } else if (current_width < 669) {
      $('html').addClass('m768').removeClass('desktop').removeClass('m320').removeClass('tablet');
    } else if (current_width < 970) {
      $('html').addClass('tablet').removeClass('desktop').removeClass('m320').removeClass('m768');
    } else if (current_width > 971) {
      $('html').addClass('desktop').removeClass('m320').removeClass('m768').removeClass('tablet');
    }
    if (current_width < 650) {
      $('html').addClass('mobile-menu').removeClass('desktop-menu');
    }
    if (current_width > 651) {
      $('html').addClass('desktop-menu').removeClass('mobile-menu');
    }
  });
})(jQuery);
