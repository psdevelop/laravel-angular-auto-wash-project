<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<!-- Modal -->
		  <div class="modal-dialog" role="document">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h3>
				  <span class="glyphicon glyphicon-scale" aria-hidden="true"></span>&nbsp;{{$service->title}}<br />
				  <span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp;{{$auto_type->title}}
				</h3>
			  </div>
			  <form id="activeForm" method="POST" action="{{url('prices')}}/savePrice">
			  <div class="modal-body">
					@include('errors.errorlist')
					{!! csrf_field() !!}
					<div class="form-group">
						{!! Form::label('cost', 'Цена: ') !!}
						<div class="input-group">
							<span class="input-group-addon">р.</span>
							<input type="number" value="" min="0" step="0.01" data-number-to-fixed="2"
							data-number-stepfactor="100" class="form-control currency focus-target" id="cost" name="cost" />
						</div>
					</div>
					<div class="form-group">
						{!! Form::label('timing', 'Время: ') !!}
						<div class="input-group">

							<span class="input-group-addon">мин.</span>
							<input type="number" value="" min="0" step="1" data-number-to-fixed="0"
							data-number-stepfactor="100" class="form-control" id="timing" name="timing" />
						</div>
					</div>
				</div>
				{!! Form::hidden('service_id', $service->id, ['class'=>'form-control']) !!}
				{!! Form::hidden('auto_type', $auto_type->id, ['class'=>'form-control']) !!}
			    <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				  {!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
			  </div>
			  </form>

		  </div>
		  </div>
	 <!-- END modal -->
</div>
