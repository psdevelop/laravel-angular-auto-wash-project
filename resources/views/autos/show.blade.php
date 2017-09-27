<div class="col-md-3 col-md-push-9">
	<h3>Опции</h3>
	@if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
	    <div class="form-group">
	      <button type="button" class="btn btn-default" onClick="newAutotypeClickEvent()">
			  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новый тип
		  </button>
		</div>


	@endif
   </div>
  <div class="col-md-9 col-md-pull-3">

  <table class="table table-bordered">
   <thead>
     <tr>
	   <th>Наименование типа</th>
	 </tr>
   </thead>
   <tbody>
		 <tr ng-repeat="auto in autos">
			 <td>
				 <a href="#" ng-click="editAutotypeClickEvent(auto.id)" ng-init="count=0"><% auto.title %></a>
				 <button class="btn btn-danger btn-xs pull-right" ng-click="deleteAutotypeClickEvent(auto.id)" ng-init="count=0">
				 <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
				 </button>
			 </td>
		 </tr>
  </tbody>
  </table>
  </div>
