$(function(){

	priceCellClickEvent = function(currentCell){
		appScope.showDynamicDialog(
			'/prices/dynload/'+currentCell.getAttribute("service-id")+'/'+currentCell.getAttribute("auto-type"),
			appScope.loadPrices,
			'ERROR loading Individual price data.'
		);
	};

});
