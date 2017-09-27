<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Новый клиент</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('users')}}/saveClient">
			<div class="modal-body">
        @include('errors.errorlist')
        {!! csrf_field() !!}
        <div class="form-group">
          {!! Form::label('phone', 'Телефон: ') !!}
          {!! Form::text('phone', null, ['class'=>'form-control']) !!}
        </div>
        <div class="form-group">
          {!! Form::label('name', 'Имя: ') !!}
          {!! Form::text('name', null, ['class'=>'form-control']) !!}
        </div>

				<div class="form-group">
				  {!! Form::label('payment_type', 'Тип оплаты: ') !!}
				  <select name="payment_type" class="form-control">
					@foreach($payment_types as $type)
						<option value="{{$type->id}}">{{$type->title}}</option>
					@endforeach
				  </select>
				</div>

        <div class="form-group">
          {!! Form::label('email', 'Email: ') !!}
          {!! Form::email('email', null, ['class'=>'form-control']) !!}
        </div>

        <!--
          <div class="form-group">
              {!! Form::label('password', 'Пароль: ') !!}
              {!! Form::password('password', ['class'=>'form-control']) !!}
          </div>
          <div class="form-group">
              {!! Form::label('password_confirmation', 'Подтверждение: ') !!}
              {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
        </div>
        -->
				<input name="wash_id" type="hidden" id="wash_id" value="{{$wash_id}}" />
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				{!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
			</div>
			</form>
		</div>
		</div>
		</div>
<!-- END modal -->
