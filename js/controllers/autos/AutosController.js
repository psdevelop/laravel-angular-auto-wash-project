$(function(){

  appScope.loadAutos = function(){
	  appScope.loadData('autos', '/autos/dynload/'+appScope.washId);
	};

  appScope.deleteAuto = function(del_path)
	{
		appHttp.get(del_path).
		success(function(data, status, headers, config){
			//showDialog(data, null);
			appScope.loadAutos();
		}).
		error(function(data, status, headers, config){
			alert(errMessage);
			appScope.loadAutos();
		});
	}

});
