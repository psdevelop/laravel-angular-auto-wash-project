var app = angular.module('washesControllerApp', [], function($interpolateProvider) {
	$interpolateProvider.startSymbol('<%');
	$interpolateProvider.endSymbol('%>');
});

var appScope;
var appHttp;
var appInterval;

app.controller('washesController',['$scope', '$http', '$interval', function($scope, $http, $interval){
	appScope = $scope;
	appHttp = $http;
	appInterval = $interval;

	$scope.washId = document.getElementById("washId").value;

	$scope.showDynamicDialog = function(loadPath, refreshFunction, errMessage)
	{
		$http.get(loadPath).
		success(function(data, status, headers, config) {
			showDialog(data, refreshFunction);
		}).
		error(function(data, status, headers, config) {
			alert(data+"\n"+errMessage);
		});
	}

	$scope.showDynamicFunctionalDialog = function(loadPath, initFunction, refreshFunction, errMessage)
	{
		$http.get(loadPath).
		success(function(data, status, headers, config) {
			showDialog(data, refreshFunction);
			initFunction();
		}).
		error(function(data, status, headers, config) {
			alert(data+"\n"+errMessage);
		});
	}

	$scope.loadDynamicForm = function(frame_id, loadPath, formId, resultFunc, errMessage)
	{
		$http.get(loadPath).
		success(function(data, status, headers, config) {
			placeForm(frame_id, data);
			addSubmitEvent(formId, resultFunc);
		}).
		error(function(data, status, headers, config) {
			alert(data+"\n"+errMessage);
		});
	}


	$scope.loadData = function(key, path, initFunction){
		$http.get(path).
		success(function(data, status, headers, config){
			$scope[key] = data;
			if(initFunction) initFunction();
			console.log('Data Load SUCCESS: '+path);
			//console.log(data);
		}).
		error(function(data, status, headers, config) {
			//console.log('Data Load ERROR: '+path);
		});
	};

	$scope.loadAutoservices = function(){
	  $scope.loadData('auto_services', '/prices/index/'+$scope.washId);
	};

}]);

$(function(){
	appScope.formatDate = function(moment){
		var dd = moment.getDate();
		var mm = moment.getMonth()+1; // Январь под номером 0!
		var yyyy = moment.getFullYear();

		var hh = moment.getHours();
		var MM = moment.getMinutes();
		var ss = moment.getSeconds();

		var checkZero = function(key){
			if(key < 10){
				key = '0' + key;
			}

			return key;
		}

		dd = checkZero(dd);
		mm = checkZero(mm);
		hh = checkZero(hh);
		MM = checkZero(MM);
		ss = checkZero(ss);

		var result = yyyy + '-' + mm + '-' + dd + ' ' + hh + ':' + MM + ':' + ss;
		return result;

	};

	appScope.formatCurrency = function(value){
		if(value % 1 === 0){
			return Number(value);
		} else {
			return (Number(value)).toFixed(2);
		}
	};

	markRow = function(cell){
		$(cell).parents('tbody').children('tr').each(function(){
		  $(this).removeClass("marked");
		});
		$(cell).parents('tr').addClass("marked");
	}

	markPlate = function(){
		$(this).addClass("marked");
	}

	placeForm = function(frame_id, data){
		$(frame_id).html(data);
	}

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
						console.log("LOAD OK!");
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

		addSubmitEvent = function(dialogId, successFunc)
		{
			$(dialogId).submit( function(e){
				var postData = $(dialogId).serializeArray();
				var formUrl = $(dialogId).attr("action");
				$.ajax(
				{
				  url: formUrl,
				  type: "POST",
				  data: postData,
				  success: function(data, textStatus, jqXHR)
				  {
				    successFunc(data);
				  },
				  error: function(data, textStatus, errorThrown)
				  {
				    successFunc(data);
				  }
				});
				e.preventDefault();
			});
		}
});
