$(function(){

	appScope.loadPayments = function(){
		appScope.loadData('payments', '/payments/dynload/'+appScope.washId);
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
	}

});
