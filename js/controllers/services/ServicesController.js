$(function(){

	appScope.loadServices = function(){
		appScope.loadData('services', '/services/dynload/'+appScope.washId);
	};
	

});
