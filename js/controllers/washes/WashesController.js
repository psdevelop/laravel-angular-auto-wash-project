$(function(){
	appScope.loadWash = function(){
		appScope.loadData('wash', '/washes/load/'+appScope.washId);
	}

	appScope.loadWash();
	appScope.loadBoxes();
	appScope.loadColors();
	appScope.loadWashsessions();
	appScope.loadRecords();
	appScope.checkWashsessions();
	appScope.refreshWashsessions = appInterval(appScope.checkWashsessions, 6000);
  appScope.loadPayments();
	appScope.loadAutos();
	appScope.loadServices();
	appScope.loadSubordinates();
	appScope.loadClients();
	appScope.loadAutoservices();


	$('a[data-toggle="tab"]').bind('shown.bs.tab', function(e){
		if(e.target.id == "servicesFrame"){
			appScope.loadServices();
		}
		else if(e.target.id == "autosFrame"){
			appScope.loadAutos();
		}
		else if(e.target.id == "paymentsFrame"){
			appScope.loadPayments();
		}
		else if(e.target.id == "recordsFrame"){
			appScope.loadRecords();
		}
		else if(e.target.id == "washsessionsFrame"){
			appScope.loadWashsessions();
		}
		else if(e.target.id == "pricesFrame"){
			appScope.loadPrices();
		}
		else if(e.target.id == "subordinatesFrame"){
			appScope.loadSubordinates();
		}
		else if(e.target.id == "clientsFrame") {
			appScope.loadClients();
		}
		else if(e.target.id == "cashboxFrame") {
			appScope.loadCashbox();
		}
		else if(e.target.id == "dutyFrame") {
			appScope.listWashsessions();
		}
		else if(e.target.id == "boxesFrame"){
			appScope.loadAutoservices();
			appScope.loadAutos();
			//appScope.loadBoxes();
			appScope.resetSvgHandler();
			appScope.checkWashsessions();
			appScope.loadColors();
			appScope.refreshWashsessions = appInterval(appScope.checkWashsessions, 6000);
		};
	});

	$('a[data-toggle="tab"]').bind('hidden.bs.tab', function(e){
		if(e.target.id == "boxesFrame"){
			appInterval.cancel(appScope.refreshWashsessions);
			appScope.resetSvgHandler();
			console.log("refresh stop!");
		}
	});

});
