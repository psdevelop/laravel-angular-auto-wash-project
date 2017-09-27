@extends('app')

@section('content')
<div class="container">
<div class="row">
  <div class="col-md-9">
  <h1>Новая мойка</h1>
  @include('errors.errorlist')
  <div ng-app="washConfigApp" ng-controller="washConfigCtrl">
    {!! Form::open(['url'=>'washes/store']) !!}
    <div class="form-group">
		{!! Form::label('title', 'Название: ') !!}
		{!! Form::text('title', null, ['class'=>'form-control']) !!}
	</div>

	<!--
	<div class="row">
	    <div class="col-md-4">
			<div class="form-group">
				{!! Form::label('boxcount', 'Количество боксов: ') !!}
				{!! Form::input('number','boxcount', 5, ['class'=>'form-control', 'ng-model'=>'boxcount']) !!}
			</div>
		</div>
	</div>

	<h2>Конфигурация боксов</h2>
	  <div class="boxfield well" ng-repeat="i in getCollection(boxcount) track by $index">
	     <h3>Бокс 1</h3>
	    <div class="form-group">
		  {!! Form::label('box<%$index%>title', 'Название: ') !!}
		  {!! Form::text('box<%$index%>title', null, ['class'=>'form-control']) !!}
	    </div>
		 <div class="form-group">
		  {!! Form::label('box<%$index%>description', 'Описание: ') !!}
		  {!! Form::text('box<%$index%>description', null, ['class'=>'form-control']) !!}
	    </div>
	  </div>
    -->

	<div class="form-group">
		{!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
	</div>
  {!! Form::close() !!}
  </div>
</div>
</div>
</div>
@stop

@section('customjs')
  <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.16/angular.min.js"></script>
  <script src="{{url('/')}}/js/angularWashConfig.js"></script>
@stop
