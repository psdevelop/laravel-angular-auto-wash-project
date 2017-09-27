$(function(){
  newDutyClickEvent = function(){
		appScope.showDynamicDialog(
			'/duties/new/'+appScope.washId,
			appScope.listWashsessions,
			'ERROR adding new duty.'
		);
	}

  currentSalaryClickEvent = function(){
		appScope.showDynamicDialog(
			'/duties/salary/'+appScope.washId,
			appScope.listWashsessions,
			'ERROR viewing salary.'
		);
	}

  openDutyClickEvent = function(){
    appScope.showDynamicDialog(
			'/duties/open/'+appScope.washId,
			appScope.listWashsessions,
			'ERROR opening a duty.'
		);
  }

  appScope.closeDutyClickEvent = function(){
    appScope.showDynamicDialog(
			'/duties/close/'+appScope.washId,
			appScope.listWashsessions,
			'ERROR closing a duty.'
		);
  }


});
