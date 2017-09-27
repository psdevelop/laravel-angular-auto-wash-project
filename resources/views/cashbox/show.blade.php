<div class="col-md-3 col-md-push-9">
	<h3>Опции</h3>
	@if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
	    <div class="form-group">
	      <button type="button" class="btn btn-default" onClick="newExpenceClickEvent()">
			  <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>&nbsp;Расход
		  </button>
		</div>
	@endif
</div>
<div class="col-md-9 col-md-pull-3">
	<h3>Сумма в кассе: <% formatCurrency(totalCashSumm()) %>&nbsp;p.</h3>
	<div class="panel-group">
		<div class="panel panel-default">
			<div class="panel-heading" role="tab" id="headingReceipts">
				<h4 class="panel-title">
					<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseReceipts" aria-expanded="false" aria-controls="collapseReceipts">
						<strong>Приход</strong><strong class="pull-right"><% totalReceiptsSumm() %></strong>
					</a>
				</h4>
			</div>

			<div id="collapseReceipts" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingReceipts">
				<div class="table-responsive">
					<table class="table table-responsive">
						<thead>
							<tr>
								<th>Внесено, р</th>
								<th>Дата</th>
								<th>Примечание</th>
							</tr>
						</thead>
						<tbody>
							<tr ng-repeat="receipt in receipts">
								<td onClick="markRow(this)"><% receipt.amount %></td>
								<td><% receipt.created_at %></td>
								<td><% receipt.comment %></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		</div>

		<div class="panel-group">
			<div class="panel panel-default">
				<div class="panel-heading" role="tab" id="headingExpences">
					<h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseExpences" aria-expanded="false" aria-controls="collapseExpences">
							<strong>Расход</strong><strong class="pull-right"><% totalExpencesSumm() %></strong>
						</a>
					</h4>
				</div>
				<div id="collapseExpences" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingExpences">
				 <div class="table-responsive">
					 <table class="table table-responsive">
						 <thead>
							 <tr>
								 <th>Выдано, р</th>
								 <th>Дата</th>
								 <th>Примечание</th>
							 </tr>
						 </thead>
						 <tbody>
							 <tr ng-repeat="expence in expences">
								 <td onClick="markRow(this)"><% expence.amount %></td>
								 <td><% expence.created_at %></td>
								 <td><% expence.comment %></td>
							 </tr>
						 </tbody>
					 </table>
				 </div>
				</div>
			</div>
		</div>
	</div>
