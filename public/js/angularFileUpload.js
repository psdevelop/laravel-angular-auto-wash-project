addMessage = function(msg){
    document.getElementById("messageWall").innerHTML =msg + document.getElementById("messageWall").innerHTML;
    //alert(msg);
};

var app = angular.module('fileUploadApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

app.directive('fileInput', ['$parse',function($parse){
  return {
    restrict:'A',
	link:function($scope, elm, attrs){
	  elm.bind('change', function(){
	    $parse(attrs.fileInput)
		.assign($scope, elm[0].files);
		$scope.$apply();
	  })
	}
  };
}]);

app.controller('fileUploadCtrl',['$scope', '$http', 
  function($scope, $http) {
	    $scope.filesChanged = function(elm){
	      $scope.files = elm.files;
		    $scope.$apply();
	    };
      
	  $scope.refreshList = function(){
      $http.post('datafiles/dynlist')
		  .success(function(dataList) {
          console.log(dataList);
          $scope.datafiles = dataList;
      });
    };
    
    $scope.refreshList();
    
    $scope.deleteItem = function(filename){
      $http.get('datafiles/dyndel/'+filename)
		  .success(function(data) {
          console.log(data);
          addMessage(data);
          $scope.refreshList();
      });
    }
    
	  $scope.upload = function(){
	    var fd = new FormData();
		  angular.forEach($scope.files, function(file){
		    fd.append('file', file);
		  });
	    $http.post('datafiles/dynadd', fd,
		  {
		    transformRequest:angular.identity,
		    headers:{'Content-Type':undefined}
		  })
		  .success(function(data) {
          console.log(data);
          addMessage(data);
          $scope.refreshList();
          
      });
	  };
  }]); 

// form action="/laravel/public/datafiles/add"
// action="/laravel/public/datafiles/add"
// onchange="angular.element(this).scope().filesChanged(this)"
// form enctype="multipart/form-data"