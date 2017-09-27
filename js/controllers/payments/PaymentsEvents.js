$(function(){

	paymentCellClickEvent = function(currentCell){
		appScope.showDynamicDialog(
			'/payments/edit/'+currentCell.getAttribute("payment-id"),
			appScope.loadPayments,
			'ERROR loading Individual payment data.'
		);
	};

});
