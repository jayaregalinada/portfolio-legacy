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
