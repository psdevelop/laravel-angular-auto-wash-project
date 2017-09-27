<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Сеанс</h4>
			</div>
			<form id="activeForm" method="POST" action="#">
				<div class="modal-body">
					<div class="table-responsive">
			    <table class="table table-bordered">
			    <thead>
			      <tr>
			 	   <th>Услуга</th>
			 	   <th>Стоимость</th>
			 	 </tr>
			    </thead>
					<tbody>
						@foreach($washservices as $washservice)
						<tr>
							<td onClick="markRow(this)">{{ $washservice->autoservice->service->title }}</td>
							<td>{{ $payment->formatCurrency($washservice->cost) }}</td>
						</tr>
						@endforeach
						@foreach($customservices as $customservice)
						<tr>
							<td onClick="markRow(this)">{{ $customservice->title }}</td>
							<td>{{ $payment->formatCurrency($customservice->cost) }}</td>
						</tr>
						@endforeach
						<tr>
							<td onClick="markRow(this)">Скидка: </td>
							<td>{{ $payment->formatCurrency($washsession->local_discount) }}</td>
						</tr>
						<tr>
							<td onClick="markRow(this)">Сумма: </td>
							<td>{{ $payment->formatCurrency($washsession->total_summ - $washsession->local_discount) }}</td>
						</tr>
					</tbody>
			   </table>
			   </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					{!! Form::submit('Ok', ['class'=>'btn btn-primary']) !!}
					<button type="button" class="btn btn-default pull-right" data-dismiss="modal" onClick="removeWashsessionClickEvent({{$washsession->id}})">Удалить</button>
				</div>
			</form>
		</div>
		</div>
	</div>
<!-- END modal -->
