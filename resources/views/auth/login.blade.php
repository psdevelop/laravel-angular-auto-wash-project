@extends('app')

@section('customcss')
  <link href="{{url('/')}}/css/signin.css" rel="stylesheet">
@stop

@section('content')
@include('errors.errorlist')



<form class="form-signin" method="POST" action="{{url('auth')}}/login">
  {!! csrf_field() !!}
  <img src="{{url('/')}}/img/chistomoika_logo.png" class="img-responsive center-block" alt="Система автоматического учёта автомоечного бизнеса CHISTOMOIKA" />
  <!--<h3 class="form-signin-heading center-block">Вход в систему</h3>-->
  <div class="form-group center-block" style="text-align:center;">
    <h4>Вход в систему</h4>
  </div>
  <div class="form-group">
    <label for="inputEmail" class="sr-only">Логин</label>
    <input type="text" name="name" id="inputEmail" class="form-control" value="{{ old('name') }}" placeholder="Логин" required autofocus>
  </div>
  <div class="form-group">
    <label for="inputPassword" class="sr-only">Пароль</label>
    <input type="password" name="password" id="password" class="form-control" placeholder="Пароль" required>
  </div>
  <!--<div class="form-group">
    <div class="checkbox">
      <label>
        <input type="checkbox" name="remember"> Запомнить меня
      </label>
    </div>
  </div>-->
  <div class="form-group">
    <button class="btn btn-lg btn-primary btn-block" type="submit">Вход</button>
  </div>
</div>

</form>

@stop
