$(function(){

	appScope.loadPrices = function(){
		appHttp.get('/prices/index/'+appScope.washId).
		success(function(data, status, headers, config) {
			appScope.prices = data;

			appScope.prices.forEach(function(element, index, array){
				$('#'+element.service_id+"_"+element.auto_id).html(appScope.formatCurrency(element.cost));
			});

		}).
		error(function(data, status, headers, config) {
			console.log("Prices data not found.");
		});
	};

});
