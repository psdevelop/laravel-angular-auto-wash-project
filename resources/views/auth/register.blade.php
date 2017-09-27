@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-9">
      @include('errors.errorlist')
      <form method="POST" action="{{url('auth')}}/register">
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
    <div class="col-md-3">
      
    </div>
  </div>
</div>
@stop
