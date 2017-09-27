$(function(){

	newAutotypeClickEvent = function(){
		appScope.showDynamicFunctionalDialog(
			'/autos/new/'+appScope.washId,
			initNewAutoDialog,
			appScope.loadAutos,
			'ERROR creating new box.'
		);
	}

	appScope.editAutotypeClickEvent = function(auto_id){
		appScope.showDynamicFunctionalDialog(
			'/autos/edit/'+auto_id,
			initEditAutoDialog,
			appScope.loadAutos,
			'ERROR creating new box.'
		);
	}

	appScope.deleteAutotypeClickEvent = function(autoId){
		appScope.showDynamicDialog(
			'/autos/remove/'+autoId,
			appScope.loadAutos,
			'ERROR deleting this auto.'
		);
	}

	initNewAutoDialog = function(){
		$('#iconCarousel').on('slid.bs.carousel', function (e) {
			var selected_icon = $(e.relatedTarget).find('img').attr('icon-data');
			$('#icon').val(selected_icon);
			//console.log('Image switch: ' + $(e.relatedTarget).find('img').attr('icon-data'));

    });
	}

	initEditAutoDialog = function(){
    var chosen_auto = $('#icon').val();
		$('#iconCarousel').carousel({interval:60});


		$('#iconCarousel').on('slid.bs.carousel', function (e) {
			var selected_icon = $(e.relatedTarget).find('img').attr('icon-data');
			$('#icon').val(selected_icon);

			console.log('Image switch: ' + $(e.relatedTarget).find('img').attr('icon-data'));

			if($('#icon').val() == chosen_auto){
				$('#iconCarousel').carousel('pause');
			}
    });
		$('#iconCarousel').carousel('cycle');
    /*
	  do{
			$('#iconCarousel').carousel('next');
		} while(chosen_auto != $('#icon').val());*/
	}


});
