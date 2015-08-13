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
