$(function(){

  appScope.showWashsessionDialog = function(wash_id){
		appHttp.get('/washsessions/createWashsession/'+wash_id).
		success(function(data, status, headers, config) {
			showDialog(data, appScope.loadPrices);
		}).
		error(function(data, status, headers, config) {
			alert('ERROR loading Individual price data.');
		});
	};

  appScope.detailWashsessionClickEvent = function(washsession_id){
    appScope.showDynamicDialog(
			'/washsessions/detail/'+washsession_id,
			appScope.listWashsessions,
			'ERROR detailing washsession.'
		);
  };

  removeWashsessionClickEvent = function(userId){
		appScope.showDynamicDialog(
			'/washsessions/remove/'+userId,
			appScope.listWashsessions,
			'ERROR deleting this washsession.'
		);
	};

});
