<!-- Box Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Новый Бокс</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('boxes')}}/store">
			<div class="modal-body">
			@include('errors.errorlist')
			{!! csrf_field() !!}
			<input name="wash_id" type="hidden" id="wash_id" value="{{$wash_id}}" />
			<div class="form-group">
				{!! Form::label('title', 'Название: ') !!}
				{!! Form::text('title', null, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('role_id', 'Сотрудник: ') !!}
				<select name="worker_id" class="form-control">
				<option value="NULL">---</option>
				@foreach($workers as $worker)
					<option value="{{$worker->id}}">{{$worker->name}}</option>
				@endforeach
				</select>
			</div>
				<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				{!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
			</div>
			</form>
		</div>
		</div>
		</div>
	</div>
<!-- END modal -->
