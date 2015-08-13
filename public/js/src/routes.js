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
