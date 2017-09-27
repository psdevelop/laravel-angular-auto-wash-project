$(function(){
  newExpenceClickEvent = function(){
		appScope.showDynamicDialog(
			'/expences/new/'+appScope.washId,
			appScope.loadCashbox,
			'ERROR showing new expences dialog.'
		);
	}

});
