_j49.controller 'ProjectController', ($scope, $http, $window, $log, $state, $stateParams, $req, $helpers, localStorageService, $timeout, $rootScope)->

  $scope.project = {}
  $scope.projects = []
  $scope.condition = {}
  _r = $window._route
  $scope.status = $helpers.getAllDefaultStatus()
  $scope.getAllTimeout = null
  $scope.getAllNextPageDelayTime = 2000

  $scope.checking = ->
    $log.info 'Checking $state', $state
    $scope.switches($state.current)

    return

  $scope.switches = (currentState)->
    switch currentState.name
      when 'index'
        $scope.gettingAll()

        return

      else
        return

    return

  $scope.pushToProjects = (data)->
    angular.forEach data, (val, key)->
      $scope.projects.push val

      return

    return

  $scope.get = (id)->
    url = _r['project.show'].replace '{project}', id
    $http.get url
    .success (successData)->
      $scope.project = successData
      $log.log successData

      return

    return

  $scope.gettingAll = ->
    $scope.projects = []
    $scope.status = $helpers.statusWhenGettingAll()
    prjct = [
      'project_page'
      'project_paginate_done'
      'project_paginate_interrupted'
    ]
    angular.forEach prjct, (v)->
      localStorageService.remove v

      return
    $timeout ->
      $scope.getAll 1
      return

    , 1500

    return

  $scope.getAll = (pageNumber)->
    url = _r['project.index']
    $rootScope.$broadcast 'projects:all',
      page: pageNumber
    $scope.status = $helpers.statusWhenGetAll()

    $req._paginate pageNumber, url
      .success (successData)->
        $log.log 'ProjectController@getAll', successData
        $rootScope.$broadcast 'projects:all:success'
        $scope.status.error = false
        localStorageService.set 'project_page', successData.success.data.current_page

        if Boolean successData.success.data.next_page_url
          if $state.is 'index'
            $scope.getAllTimeout = $timeout ->
              $scope.getAll successData.success.data.current_page + 1

              return
            , $scope.getAllNextPageDelayTime
          else
            localStorageService.set 'project_paginate_interrupted', true
        else
          $rootScope.$broadcast 'projects:all:complete'
          $scope.status.loading = false
          localStorageService.set 'project_paginate_done', true

        return
      .error (err)->
        $log.error 'ProjectController@getAll::error', errorData
        $rootScope.$broadcast 'projects:all:error'
        $rootScope.$broadcast 'errorOccured'
        $scope.status = $helpers.statusWhenError errorData.error.message

        return
      .then (thenData)->
        $scope.pushToProjects thenData.data.success.data.data
        $scope.status.loadingFirstTime = false

        return

    return

  $scope.view = (productId)->
    url = _r['project.show'].replace '{project}', productId
    $http.get url
      .success (successData)->
        $log.log successData
        $scope.project = successData.success.data

        return
      .error (err)->
        $log.error errData

        return

    return

  $scope.checking()

  return