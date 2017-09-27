<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Профиль клиента</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('clients')}}/update">
				<div class="modal-body">
				@include('errors.errorlist')
				{!! csrf_field() !!}
			<div class="form-group">
				{!! Form::label('name', 'Имя: ') !!}
				{!! Form::text('name', $employee->name, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('phone', 'Телефон: ') !!}
				{!! Form::text('phone', $employee->phone, ['class'=>'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email', 'Email: ') !!}
				{!! Form::email('email', $employee->email, ['class'=>'form-control']) !!}
			</div>
			<input name="user_id" type="hidden" id="user_id" value="{{$employee->id}}" />

			<div class="form-group">
				{!! Form::label('payment_type', 'Тип оплаты: ') !!}
				<select name="payment_type" class="form-control">
				@foreach($payment_types as $type)
					@if($employee->paymenttype_id == $type->id)
						<option value="{{$type->id}}" selected>{{$type->title}}</option>
					@else
						<option value="{{$type->id}}">{{$type->title}}</option>
					@endif
				@endforeach
				</select>
			</div>

			<div class="form-group">
				{!! Form::label('new_password', 'Новый пароль: ') !!}
				{!! Form::password('new_password', ['class'=>'form-control']) !!}
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
