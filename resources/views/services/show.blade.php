<div class="col-md-3 col-md-push-9">
	<h3>Опции</h3>
	@if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
	    <div class="form-group">
	      <!-- Button trigger modal -->
		  <button type="button" class="btn btn-default" onClick="newServiceClickEvent()">
			  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новая услуга
		  </button>
		</div>

	@endif
   </div>
  <div class="col-md-9 col-md-pull-3">
  <table class="table table-bordered">
   <thead>
     <tr>
	   <th>Название услуги</th>
	 </tr>
   </thead>
   <tbody>

      <tr ng-repeat="service in services">
	  <td>
			<a href="#"><% service.title %></a>
			<button class="btn btn-danger btn-xs pull-right" ng-click="deleteServiceClickEvent(service.id)" ng-init="count=0">
			<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
			</button>
		</td>
	  </tr>
  </tbody>
  </table>
  </div>
