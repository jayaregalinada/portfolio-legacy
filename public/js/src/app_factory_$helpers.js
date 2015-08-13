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
