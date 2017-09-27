$(function(){

	appScope.loadWashsessions = function(){
	  appScope.loadData('washsessions', '/washsessions/dynload/'+appScope.washId, function(){
	    appScope.auto_select = appScope.washsessions.autos[0].id;
			appScope.box_select = appScope.washsessions.boxes[0].id;

			appScope.curNow = new Date();
			appScope.applyColors();
	  });
	};

	appScope.listWashsessions = function(){
	  appScope.loadData('duty_washsessions', '/washsessions/list/'+appScope.washId, function(){
			appScope.total_washsessions_summ = 0;
			appScope.total_washsessions_discounts = 0;
			appScope.total_washsessions_nocash = 0;
			for(var i = 0; i < appScope.duty_washsessions.length; i++){
				appScope.total_washsessions_summ += Number(appScope.duty_washsessions[i].payment.total_cost);
				appScope.total_washsessions_discounts += Number(appScope.duty_washsessions[i].local_discount);
				if(appScope.duty_washsessions[i].car.user.paymenttype_id==2){
					appScope.total_washsessions_nocash += Number(appScope.duty_washsessions[i].payment.total_cost);
				}
			}
			appScope.loadWash();
			appScope.applyColors();
	  });

	};

	appScope.checkWashsessions = function(){
		appScope.checkBoxes();
		appScope.loadData('current_ws', '/washsessions/check/'+appScope.washId, appScope.applyColors);
	};

	appScope.applyColors = function(){
		appScope.insertSvgListener();
		$('.car-glyph').each(function(key){
			var glyph_color = $(this).attr('fill-color');
			var svg = this;
			var svgDoc = svg.contentDocument;
	    var filler = svgDoc.getElementById("cvet");
	    filler.setAttributeNS(null,  "fill", "#"+glyph_color);
		});
	}

	appScope.resetSvgHandler = function(){
		$('.car-empty').attr('handles', '0');
	}

	appScope.insertSvgListener = function(){
		$('.car-empty').each(function(key){

			var handles = $(this).attr('handles');
			if(handles == 0){
				var box_id = $(this).attr('box-id');
				var box_worker = $(this).attr('box-worker');
				var svg = this;
				var svgDoc = svg.contentDocument;
		    var clicker = svgDoc.getElementById("klic");
				clicker.addEventListener("click", function(){
					if(box_worker == 0){
						appScope.editBoxClickEvent(box_id);
					} else if(appScope.wash.duty_id == 0){
						openDutyClickEvent();
					}
					else {
						appScope.setBoxSelect(box_id);
						$('#boxloadFormModal').modal('show');
						console.log("box select!");
					}
				}, false);
				$(this).attr('handles', '1');
			}
		});
	}

	appScope.getTotalIncome = function(box){
		var result = 0;
		for(var i = 0; i < box.washsessions.length; i++){
			var payment = box.washsessions[i].payment;
			result += Number(payment.total_cost);
		}
		return result;
	}

	appScope.getTotalSalary = function(box){
		var result = 0;
		for(var i = 0; i < box.washsessions.length; i++){
			var payment = box.washsessions[i].payment;
			result += Number(payment.total_cost);
		}
		result = result * .3;
		return result;
	}

	appScope.getTotalProfit = function(box){
		var result = 0;
		for(var i = 0; i < box.washsessions.length; i++){
			var payment = box.washsessions[i].payment;
			result += Number(payment.total_cost);
		}
		result = result * .7;
		return result;
	}

	appScope.loadColors = function(){
	  appScope.loadData('colors', '/colors/index');
	};

});
