$(function(){

	appScope.editUserClickEvent = function(userId){
		appScope.showDynamicDialog(
			'/users/edit/'+userId,
			appScope.loadSubordinates,
			'ERROR editing user.'
		);
	}

	appScope.deleteUserClickEvent = function(userId){
		appScope.showDynamicDialog(
			'/users/remove/'+userId,
			appScope.loadSubordinates,
			'ERROR deleting this user.'
		);
	}

	appScope.editClientClickEvent = function(userId){
		appScope.showDynamicDialog(
			'/clients/edit/'+userId,
			appScope.loadClients,
			'ERROR editing Client.'
		);
	}

	appScope.deleteClientClickEvent = function(clientId){
		appScope.showDynamicDialog(
			'/users/remove/'+clientId,
			appScope.loadClients,
			'ERROR deleting this client.'
		);
	}

	appScope.deleteClientDiscountClickEvent = function(clientId, discountId){
		appScope.showDynamicDialog(
			'/discounts/remove/'+clientId+"/"+discountId,
			appScope.loadClients,
			'ERROR deleting this discount.'
		);
	}

	newClientClickEvent = function(){
		appScope.showDynamicDialog(
			'/clients/new/'+appScope.washId,
			appScope.loadClients,
			'ERROR creating new client.'
		);
	}

	appScope.newDiscountClickEvent = function(clientId){
		appScope.showDynamicDialog(
			'/discounts/new/'+appScope.washId+'/'+clientId,
			appScope.loadClients,
			'ERROR adding new discount.'
		);
	}


	$("#userForm").submit( function(e){
		var postData = $(this).serializeArray();
		var formUrl = $(this).attr("action");

		$.ajax(
		{
		  url: formUrl,
		  type: "POST",
		  data: postData,
		  success: function(data, textStatus, jqXHR)
		  {
		      appScope.loadSubordinates();
		  },
		  error: function(jqXHR, textStatus, errorThrown)
		  {
		      appScope.loadSubordinates();
		  }
		});
		e.preventDefault();
		$('#userFormModal').modal('hide');
	});

});
