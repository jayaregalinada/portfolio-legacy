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
