<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- Modal -->
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>
						<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;Оплата
					</h3>
			  </div>
			  <form id="activeForm" method="POST" action="{{url('payments')}}/update">
					<div class="modal-body">
						@include('errors.errorlist')
						{!! csrf_field() !!}
						<div class="form-group">
							<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;Стоимость: {{($payment->total_cost - $payment->washsession->local_discount)}}&nbsp;₽<br />
							<span class="glyphicon glyphicon-circle-arrow-down" aria-hidden="true"></span>&nbsp;Оплачено: {{$payment->formatCurrency($payment->render)}}&nbsp;₽<br /><br />

							{!! Form::label('render', 'К оплате: ') !!}
							<div class="input-group">
								<span class="input-group-addon">р.</span>
								<input type="number" value="{{($payment->total_cost - $payment->washsession->local_discount) - $payment->render}}" min="0" step="0.01" data-number-to-fixed="2"
								data-number-stepfactor="100" class="form-control currency focus-target" id="ws_cost" name="total_cost" />
							</div>

							{!! Form::label('render', 'Внести: ') !!}
							<div class="input-group">
								<span class="input-group-addon">р.</span>
								<input type="number" value="{{($payment->total_cost - $payment->washsession->local_discount) - $payment->render}}" min="0" step="0.01" data-number-to-fixed="2" onKeyUp ="recalculateChange()"
								data-number-stepfactor="100" class="form-control currency focus-target" id="ws_pay" name="addition" />
							</div>
						</div>
						<div class="form-group">
							<p >Сдача: <span id="ws_change">0</span> р.</p>
						</div>
						{!! Form::hidden('payment_id', $payment->id, ['class'=>'form-control']) !!}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
						{!! Form::submit('Сохранить', ['class'=>'btn btn-primary pull-right']) !!}
					</div>
			  </form>

		  </div>
		</div>
	 <!-- END modal -->
</div>
