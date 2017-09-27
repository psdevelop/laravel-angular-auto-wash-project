$(function(){

	appScope.setWashsessionParameters = function(car){
		appScope.auto_select = car.autotype.id;
		appScope.car_select = car.id;
		appScope.discounts = car.user.discounts;
		//recalculateTotals();
	}

	toggleServiceCheckBox = function(widget){
		var currentCheckbox = 	$('input[type=checkbox]', widget)[0];
		if(currentCheckbox.checked){
			removeService($(currentCheckbox).val());
			$('.checkmark', widget).hide();
			$(widget).removeClass("checked");
			currentCheckbox.checked = false;
			console.log("Removing: "+$(currentCheckbox).val());
		}else{
			appendService($(currentCheckbox).val());
			$(widget).addClass("checked");
			$('.checkmark', widget).show();
			currentCheckbox.checked = true;
			console.log("Appending: "+$(currentCheckbox).val());
		}
	}

	appScope.checkBoxLoadSubmit = function(){
		if(appScope.auto_servicesList.length <= 0){
			$('.ws_submit').attr('disabled', 'disabled');
		} else {
			$('.ws_submit').removeAttr('disabled');
		}
	}

	appScope.setBoxSelect = function(key){
		appScope.box_select = key;
	}

	appScope.paymentCloseEvent = function(box){
		console.log('Payment close! '+box.washsession.payment.id);
		appScope.showDynamicDialog(
			'/payments/edit/'+box.washsession.payment.id,
			function(){ appScope.freeBoxEvent(box); },
			'ERROR closing Individual payment data.'
		);
	};

	appScope.freeBoxEvent = function(box){
		appHttp.get('/boxes/free/'+box.id).
		success(function(data, status, headers, config) {
			appScope.checkWashsessions();
			//appScope.paymentCloseEvent(box);
		}).
		error(function(data, status, headers, config) {
			console.log('ERROR freeing box '+box_id);
			appScope.checkWashsessions();
		});
	};

	appScope.editBoxClickEvent = function(editboxId){
		appScope.showDynamicDialog(
			'/boxes/edit/'+editboxId,
			appScope.loadBoxes,
			'ERROR editing this box.'
		);
	}

	searchPeriodEvent = function(){
		var period_start = $("#period_start").val();
		var period_end = $("#period_end").val();

		appHttp.get('/boxes/find/'+appScope.washId+'/'+period_start+'/'+period_end).
		success(function(data, status, headers, config){
			appScope['records'] = data;
			console.log("Period search success!");
		}).
		error(function(data, status, headers, config){
			alert(errMessage);
			appScope['records'] = [];
		});

	}

	toggleRecordsClickEvent = function(){
	  $('.panel-collapse').collapse('toggle');
	}

	reportTypeChangeEvent = function(){

		if($('#report_type').val() == 0){
			console.log('Report type: Zero');
		}else if($('#report_type').val() == 1){
			appScope.loadDynamicForm(
				'#report_parameters','/reports/boxes/parameters/'+appScope.washId,
				'#boxesReportForm', placeReport, 'ERROR loading boxes report parameters.'
			);
		}else if($('#report_type').val() == 2){
			appScope.loadDynamicForm(
				'#report_parameters','/reports/clients/parameters/'+appScope.washId,
				'#clientsReportForm', placeReport, 'ERROR loading clients report parameters.'
			);
		}else if($('#report_type').val() == 3){
			appScope.loadDynamicForm(
				'#report_parameters','/reports/noncash/parameters/'+appScope.washId,
				'#clientsReportForm', placeReport, 'ERROR loading noncash report parameters.'
			);
		}else if($('#report_type').val() == 4){
			appScope.loadDynamicForm(
				'#report_parameters','/reports/duties/parameters/'+appScope.washId,
				'#dutiesReportForm', placeReport, 'ERROR loading duties report parameters.'
			);
		}else if($('#report_type').val() == 5){
			appScope.loadDynamicForm(
				'#report_parameters','/reports/boxstat/parameters/'+appScope.washId,
				'#boxstatReportForm', placeReport, 'ERROR loading box statistics report parameters.'
			);
		}

	}

	placeReport = function(data){
		$('#report_view').html(data);
	}

	newBoxClickEvent = function(){
		appScope.showDynamicDialog(
			'/boxes/new/'+appScope.washId,
			appScope.loadBoxes,
			'ERROR creating new box.'
		);
	}

	$('#boxloadFormModal').on('show.bs.modal', function (e){
		$('#boxloadForm')[0].reset();
		appScope.found_clients = [];
		appScope.found_cars = [];
		appScope.resetServices();
		appScope.recalculateTotals();
		appScope.startDateRefresh();
		appScope.checkBoxLoadSubmit();
	});

	$('#boxloadFormModal').on('hide.bs.modal', function (e){
		$('#boxloadForm')[0].reset();
		appScope.found_clients = [];
		appScope.found_cars = [];
		appScope.resetServices();
		appScope.recalculateTotals();
		appScope.stopDateRefresh();
	});

	$("#boxloadForm").submit( function(e){
		var postData = $(this).serializeArray();
		var formUrl = $(this).attr("action");

		$.ajax(
		{
			url: formUrl,
			type: "POST",
			data: postData,
			success: function(data, textStatus, jqXHR)
			{
				appScope.loadBoxes();
				appScope.checkWashsessions();
				console.log(data);
			},
			error: function(data, textStatus, errorThrown)
			{
				appScope.loadBoxes();
				appScope.checkWashsessions();
			}
		});
		e.preventDefault();
		$('#boxloadFormModal').modal('hide');
	});
});
