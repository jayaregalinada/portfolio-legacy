_j49.controller 'IndexController', ($scope, $state, $stateParams, $rootScope, $window, $log)->

  _r = $window._route

  $scope.checkingState = ->
    $log.log 'Checking $state...', $state
    $log.log 'Checking location...', $window.location
    $log.log 'Checking $stateParams', $stateParams

    return

  $scope.goToProjects = ->



  $scope.checkingState()

  return