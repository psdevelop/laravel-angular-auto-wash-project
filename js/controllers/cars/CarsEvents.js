$(function(){

	appScope.newAutoClickEvent = function(clientId){
		appScope.showDynamicDialog(
			'/cars/new/'+appScope.washId+'/'+clientId,
			appScope.loadClients,
			'ERROR adding new car.'
		);
	}

	$('#iconCarousel').on('slide.bs.carousel', function(e){
    var newSrc = $(e.relatedTarget).find('img').attr('src');
    console.log(newSrc);
    $('#icon').val(newSrc);
  });

});
