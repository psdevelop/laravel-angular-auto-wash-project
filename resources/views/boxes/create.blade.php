@extends('app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-6">

		<div class="form-group"> 
		  <h1>Новый бокс</h1>
		</div>

		@include('errors.errorlist')
		<form method="POST" action="{{url('boxes')}}/createBox">
		{!! csrf_field() !!}

		<div class="form-group"> 
		  {!! Form::label('title', 'Название: ') !!}
		  {!! Form::text('title', null, ['class'=>'form-control']) !!}
		</div>
		<div class="form-group"> 
		  {!! Form::label('role_id', 'Мойка: ') !!}
		  <select name="wash_id" class="form-control">
			@foreach($washes as $wash)
				@if($wash->id == $current_wash->id)
				  <option value="{{$wash->id}}" selected='selected' >{{$wash->title}}</option>
				@else
				<option value="{{$wash->id}}">{{$wash->title}}</option>
				@endif
			@endforeach
		  </select>		
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
		<div class="form-group">
		  {!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
		</div>

		</form>
	</div>
  </div>
</div>  
@stop