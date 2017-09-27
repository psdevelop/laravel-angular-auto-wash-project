<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- Modal -->
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h3>
						<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;Расход из кассы
					</h3>
			  </div>
			  <form id="activeForm" method="POST" action="{{url('expences')}}/create">
					<div class="modal-body">
						@include('errors.errorlist')
						{!! csrf_field() !!}
						<div class="form-group">
							<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;В кассе: {{ $cashboxTotal }}&nbsp;р.<br />
							<p>&nbsp;</p>
							{!! Form::label('receiver_id', 'Кому: ') !!}
							<div class="form-group">
								<select name="receiver_id" class="form-control">
									@foreach($employees as $employee)
										<option value="{{$employee->id}}">{{$employee->name}}</option>
									@endforeach
								</select>
							</div>
							{!! Form::label('new_expence', 'Расход: ') !!}
							<div class="input-group">
								<span class="input-group-addon">р.</span>
								<input type="number" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100"
									onInput="if($(this).val()>{{ $cashboxTotal }}){$(this).val({{ $cashboxTotal }})};"
									class="form-control currency focus-target" id="ws_expence_amount" name="amount" />
							</div>
							{!! Form::label('new_expence', 'Примечание: ') !!}
							<div class="input-group">
								<span class="input-group-addon">
									<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>
								</span>
								<input type="text" min="0" step="0.01" data-number-to-fixed="2" data-number-stepfactor="100"
								  class="form-control currency focus-target" id="ws_expence_comment" name="comment" />
							</div>
						</div>
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
