$(function(){

	newServiceClickEvent = function(){
		appScope.showDynamicDialog(
			'/services/new/'+appScope.washId,
			appScope.loadServices,
			'ERROR creating new service.'
		);
	}

	appScope.deleteServiceClickEvent = function(serviceId){
		appScope.showDynamicDialog(
			'/services/remove/'+serviceId,
			appScope.loadServices,
			'ERROR deleting this service.'
		);
	}
});
