@extends('app')

@section('content')

<div class="container">
  <div class="row">
    <div class="col-md-6">
	    <div class="form-group">
		   <h1>Новый сотрудник</h1>
		</div>

		@include('errors.errorlist')
		<form method="POST" action="{{url('washes')}}/createUser">
		{!! csrf_field() !!}

		<div class="form-group">
		  {!! Form::label('name', 'Имя: ') !!}
		  {!! Form::text('name', null, ['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  {!! Form::label('phone', 'Телефон: ') !!}
		  {!! Form::text('phone', null, ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
		  {!! Form::label('email', 'Email: ') !!}
		  {!! Form::email('email', null, ['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  {!! Form::label('role_id', 'Должность: ') !!}
		  <select name="role_id" class="form-control">
			@foreach($roles as $item)
				<option value="{{$item->id}}">{{$item->name}}</option>
			@endforeach
		  </select>
		</div>
		<div class="form-group">
		  {!! Form::label('password', 'Пароль: ') !!}
		  {!! Form::password('password', ['class'=>'form-control']) !!}
		</div>

		<div class="form-group">
		  {!! Form::label('password_confirmation', 'Подтверждение: ') !!}
		  {!! Form::password('password_confirmation', ['class'=>'form-control']) !!}
		</div>
		<div class="form-group">
		  {!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
		</div>
		</form>

			</div>
		  </div>
		</div>


@stop
