var app = angular.module('boxControllerApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

var appScope;

app.controller('boxController',['$scope', '$http', '$interval','$compile', function($scope, $http, $interval, $compile){
	$scope.washId = document.getElementById("washId").value;
	$scope.boxId = document.getElementById("boxId").value;
	$scope.curNow = new Date();

	$scope.auto_servicesList = [];
	$scope.total_price = 0;
	$scope.total_timing = 0;
	appScope = $scope;

	$scope.formatCurrency = function(value){
		if(value % 1 === 0){
			return Number(value);
		} else {
			return (Number(value)).toFixed(2);
		}
	};

	$scope.showDynamicDialog = function(loadPath, refreshFunction, errMessage)
	{
		$http.get(loadPath).
		success(function(data, status, headers, config) {
			showDialog(data, refreshFunction);
		}).
		error(function(data, status, headers, config) {
			alert(errMessage);
		});
	}

	$scope.showWashsessionDialog = function(wash_id){
		$http.get('/washsessions/createWashsession/'+wash_id).
		success(function(data, status, headers, config) {
			showDialog(data, appScope.loadPrices);
		}).
		error(function(data, status, headers, config) {
			alert('ERROR loading Individual price data.');
		});
	};

	$scope.freeBox = function(box_id){
		$http.get('/boxes/free/'+box_id).
		success(function(data, status, headers, config) {
			$scope.refreshSession();
		}).
		error(function(data, status, headers, config) {
			console.log('ERROR freeing box '+box_id);
		});
	};

	$scope.loadData = function(key, path, initFunction){
		$http.get(path).
		success(function(data, status, headers, config){
			$scope[key] = data;
			//console.log(data);
			if(initFunction) initFunction();
			console.log('Data Load SUCCESS: '+path);
		}).
		error(function(data, status, headers, config) {
			console.log('Data Load ERROR: '+path);
		});
	};

	$scope.loadBox = function(){
	  $scope.loadData('box', '/boxes/singleload/'+$scope.boxId, function(){
			$scope.auto_select = $scope.box.autos[0].id;
		});
	};

	$scope.refreshSession = function(){
	  $scope.loadData('washsession', '/boxes/singlerefresh/'+$scope.boxId, function(){
			$scope.curNow = new Date();
		});
	};

	$scope.loadBox();
	$scope.refreshSession();
	$scope.refreshWashsession = $interval( $scope.refreshSession, 6000);

}]);

$(function(){
		$('a[data-toggle="tab"]').bind('shown.bs.tab', function(e) {
			if(e.target.id == "boxFrame") {
				appScope.loadBox();
			}
			else if(e.target.id == "paymentsFrame") {
				appScope.loadBoxPayments();
			};
		});

		showDialog = function(data, callback){
			var modalId = "#activeFormModal";
			var formId = "#activeForm";

			document.getElementById("dialogWall").innerHTML += 	data;

			$(modalId).on('shown.bs.modal', function(e){
				$('.focus-target').focus().select();
			});

			$(formId).submit( function(e) {
				var postData = $(this).serializeArray();
				var formUrl = $(this).attr("action");

				$.ajax(
					{
						url: formUrl,
						type: "POST",
						data: postData,
						success: function(data, textStatus, jqXHR)
						{
							callback();
							console.log("prices OK!");
						},
						error: function(jqXHR, textStatus, errorThrown)
						{
							callback();
							console.log("BUG!");
						}
					});
					e.preventDefault();
					$(modalId).modal('hide');
				});

				$(modalId).modal('toggle');
				$(modalId).on('hide.bs.modal', function(e){
					$(modalId).remove();
				});
			};

			$("#boxloadForm").submit( function(e) {
				var postData = $(this).serializeArray();
				var formUrl = $(this).attr("action");

				$.ajax(
				{
				  url: formUrl,
				  type: "POST",
				  data: postData,
				  success: function(data, textStatus, jqXHR)
				  {
						appScope.loadBox();
						appScope.refreshSession();
					  console.log(data);
				  },
				  error: function(data, textStatus, errorThrown)
				  {
						$scope.loadBox();
						$scope.refreshSession();
					  console.log(data);
				  }
				});
				e.preventDefault();
				$('#boxloadFormModal').modal('hide');

			});

			appendService = function(){
				var searchId = $('#service_selector').val();
				for(var i = 0; i < appScope.box.auto_services.length; ++i){
				    if(appScope.box.auto_services[i].id == searchId){
					    appScope.auto_servicesList.push(appScope.box.auto_services[i]);
							recalculateTotals();
							return;
					}
				}
			};

			removeService = function(element){
				var key =  Number(element.getAttribute("key-value"));
				appScope.auto_servicesList.splice(key, 1);
				recalculateTotals();
			};

			recalculateTotals = function(){
				appScope.total_price = 0;
				var price_sum = 0;
				var timing_sum = 0;
				for(var f = 0; f < appScope.auto_servicesList.length; ++f){
					price_sum += Number(appScope.auto_servicesList[f].cost);
					timing_sum += Number(appScope.auto_servicesList[f].timing);
				}
				appScope.total_price = price_sum;
				appScope.total_timing = timing_sum;
				appScope.$apply();
			};

			recalculateChange = function()
			{
				var cost = Number($('#ws_cost').val());
				var pay = Number($('#ws_pay').val());
		    var change = pay - cost;
				if(change > 0){
					$('#ws_change').html(appScope.formatCurrency(change));
				} else {
					$('#ws_change').html(0);
				}
			};
});
