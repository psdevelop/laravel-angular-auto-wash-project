var app = angular.module('artEditApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

app.controller('artEditAppCtrl',['$scope', '$http', function($scope, $http){
  /*$scope.items = [
    {'name':'MikroTIK', 'price':'3000'},
	{'name':'TP-Link', 'price':'1700'}
  ];*/
  
  loadArticles($scope, $http); 
  $scope.go = function(id)
  {
	
	$http.get('articles/dyndel/'+id).
    success(function(data, status, headers, config) {
      $scope.items = data;
    }).
    error(function(data, status, headers, config) {
      alert("Error deleting data");
    });
  }
  
}]);

function loadArticles($scope, $http)
{
  $http.get('articles/dynload').
    success(function(data, status, headers, config) {
      $scope.items = data;
    }).
    error(function(data, status, headers, config) {
      alert("Error loading data");
    });
}

