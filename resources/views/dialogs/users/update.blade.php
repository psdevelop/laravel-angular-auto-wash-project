<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Профиль сотрудника</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('users')}}/update">
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
				{!! Form::label('role_id', 'Должность: ') !!}
				<select name="role_id" class="form-control">
				@foreach($roles as $item)
				@if($employee->role_id == $item->id)
				  <option value="{{$item->id}}" selected>{{$item->name}}</option>
				@else
					<option value="{{$item->id}}">{{$item->name}}</option>
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
