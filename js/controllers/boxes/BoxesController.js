$(function(){
	appScope.auto_servicesList = [];
	appScope.found_clients = [];
	appScope.found_cars = [];
	appScope.discounts = [];
	appScope.custom_service_count = 0;
	appScope.washsession = {};
	appScope.raw_price = 0;
	appScope.total_price = 0;
	appScope.combined_price = 0;
	appScope.total_timing = 0;
	appScope.washsession_discount = 0;
	appScope.curNow = new Date();

	appScope.loadBoxes = function(){
	  appScope.loadData('boxes', '/boxes/dynload/'+appScope.washId, appScope.checkWashsessions);
	};

	appScope.checkBoxes = function(){
		appScope.loadData('new_boxes', '/boxes/occupied/'+appScope.washId, function(){
			for(var i = 0; i < appScope.new_boxes.length; i++){
				if(!appScope.boxes) return;
				if(!appScope.new_boxes) return;
				if(appScope.boxes[i].washsession_id != appScope.new_boxes[i].washsession_id){
					appScope.boxes[i].washsession_id = appScope.new_boxes[i].washsession_id;
				}
			}
		})
	}

	appScope.loadRecords = function(){
		appScope.loadData('records', '/boxes/index/'+appScope.washId);
	}

	switchToForm = function()
	{
		if($('#order_switch').val() != 0){
			$('#order_switch').val(0);
			console.log("Switching to form!");
		}
	}
	searchClient = function(field){
		var key = $(field).val();
		if((key!=="")&&(key!==" ")){
			appScope.searchUser(key, field);
			appScope.searchCar(key, field);
			$('#order_switch').val(1);
			console.log("Searching: "+key);
		}else{
			appScope.found_clients = [];
			appScope.found_cars = [];
			console.log("Search Off!");
			$('#order_switch').val(0);
		}
	}

	appScope.searchUser = function(search_key, field)
	{
		appHttp.get('/users/find/'+search_key+'/'+appScope.washId).
		success(function(data, status, headers, config){
			var key = $(field).val();
			if((key!=="")&&(key!==" ")){
			  appScope.found_clients = data;
			} else {
				appScope.found_clients = [];
			}
		}).
		error(function(data, status, headers, config){
			alert(errMessage);
			appScope.loadAutos();
		});
	}

	appScope.searchCar = function(search_key, field)
	{
		appHttp.get('/cars/find/'+search_key+'/'+appScope.washId).
		success(function(data, status, headers, config){
			var key = $(field).val();
			if((key!=="")&&(key!==" ")){
			  appScope.found_cars = data;
			} else {
			  appScope.found_cars = [];
			}
		}).
		error(function(data, status, headers, config){
			alert(errMessage);
			$scope.loadAutos();
		});
	}

	appScope.recalculateTotals = function(){
		appScope.raw_price = 0;
		appScope.total_price = 0;
		appScope.total_timing = 0;
		var price_sum = 0;
		var timing_sum = 0;
		for(var f = 0; f < appScope.auto_servicesList.length; ++f){
			price_sum += Number(appScope.auto_servicesList[f].cost);
			timing_sum += Number(appScope.auto_servicesList[f].timing);
		}

		if(appScope.custom_service_count > 0){
			for(var g = 0; g < appScope.custom_service_count; ++g){
				var custom_service_cost = $("#custom_service_cost_"+g).val();
				var custom_service_time = $("#custom_service_time_"+g).val();
				console.log(custom_service_cost);
				price_sum += Number(custom_service_cost);
				timing_sum += Number(custom_service_time);
			}
		}

		if(appScope.discounts.length > 0){
			appScope.raw_price = price_sum;
			//appScope.total_price = (price_sum * (100 - appScope.discounts[0].amount) * 0.01) - appScope.washsession_discount;
			appScope.total_price = price_sum;
			appScope.combined_price = price_sum - appScope.washsession_discount;

			$('#discount').remove();

			$('<input />').attr('type', 'hidden')
			.attr('id', 'discount')
			.attr('name', 'discount')
			.attr('value', appScope.discounts[0].amount)
			.appendTo('#boxloadForm');
		}else{
			appScope.total_price = price_sum;
			appScope.combined_price = price_sum - appScope.washsession_discount;
		}
		appScope.total_timing = timing_sum;
		appScope.checkBoxLoadSubmit();
	}

	appendCustomService = function(){
		var newService = '<li class="list-group-item service-custom" id="custom_service_'+appScope.custom_service_count+'"><input class="input-xs" name="custom_service_title['+appScope.custom_service_count+']" size=4 type="text" value="Услуга '+(appScope.custom_service_count+1)+'" ></input> / <input class="input-xs" onInput="appScope.recalculateTotals()" name="custom_service_cost['+appScope.custom_service_count+']" id="custom_service_cost_'+appScope.custom_service_count+'" size=4 type="text" value="0" ></input>&nbsp;p. / <input class="input-xs" onInput="appScope.recalculateTotals()" name="custom_service_time['+appScope.custom_service_count+']" id="custom_service_time_'+appScope.custom_service_count+'" size=4 type="text" value="10" ></input>&nbsp;мин.</li>';
		$(newService).insertBefore($('#services_custom_end'));
    appScope.custom_service_count+=1;
		appScope.recalculateTotals();
	}

	removeCustomService = function(){
		if(appScope.custom_service_count == 0) return;
    $('#custom_service_'+(appScope.custom_service_count-1)).remove();
		appScope.custom_service_count-=1;
		appScope.recalculateTotals();
	}

	appendService = function(keyVal){
		var key =  Number(keyVal);
		for(var i = 0; i < appScope.washsessions.auto_services.length; ++i){
		    if(appScope.washsessions.auto_services[i].id == keyVal){
			    appScope.auto_servicesList.push(appScope.washsessions.auto_services[i]);
					appScope.recalculateTotals();
					return;
			}
		}
		appScope.recalculateTotals();
	}

	appScope.editService = function(keyVal, costVal){
		var key =  Number(keyVal);
		for(var i = 0; i < appScope.washsessions.auto_services.length; ++i){
		    if(appScope.washsessions.auto_services[i].id == keyVal){
			    appScope.washsessions.auto_services[i].cost = costVal;
					appScope.recalculateTotals();
					return;
			}
		}
		appScope.recalculateTotals();
	}

	removeService = function(keyVal){
		var key =  Number(keyVal);
		for(var i = 0; i < appScope.auto_servicesList.length; ++i){
		    if(appScope.auto_servicesList[i].id == keyVal){
			    appScope.auto_servicesList.splice(i, 1);
					appScope.recalculateTotals();
					return;
			}
		}
		appScope.recalculateTotals();
	}

	appScope.resetServices = function(){
		appScope.auto_servicesList = [];
		appScope.discounts = [];
		appScope.washsession_discount = 0;
		appScope.custom_service_count = 0;
		$(".service-custom").remove();
		var checkboxes = $("#selectedServicesList").find(":checkbox");
		checkboxes.prop('checked', false);
		var lis = $("#selectedServicesList").find("li");
		lis.removeClass("checked");
		var checkmarks = $("#selectedServicesList").find(".checkmark");
		checkmarks.hide();
		appScope.recalculateTotals();
	}

	appScope.refreshDate = function(){
		appScope.curNow = new Date();
	}

	appScope.startDateRefresh = function(){
		appScope.runTime = appInterval(appScope.refreshDate, 200);
	}

	appScope.stopDateRefresh = function(){
		appInterval.cancel(appScope.runTime);
	}

});
