$(function(){

	appScope.loadClients = function(){
		appScope.loadData('clients', '/users/clients/'+appScope.washId);
	};

	appScope.loadSubordinates = function(){
	  appScope.loadData('subordinates', '/users/workers/'+appScope.washId);
	};

});
