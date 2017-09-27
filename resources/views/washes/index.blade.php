@extends('app')


@section('content')
   <div class="container">
  <div class="row">
      <!-- Боковая панель опций -->
	  <div class="col-md-3 col-md-push-9">
			@if(Auth::check() && Auth::user()->hasRole('Director'))
			  <div>
				<h3>Опции</h3>
				<div class="form-group">
				  <a class="btn btn-default" href="{{ url('/washes/create') }}">
					<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Добавить мойку
				  </a>
				</div>
			  </div>
			@endif
      </div>

	  <!-- Область контента -->
      <div class="col-md-9 col-md-pull-3">
		  <h1>Мои мойки:</h1>
		  <table class="table table-bordered">
		   <thead>
			 <tr>
			   <th>Название</th>
			   <th>Дата создания</th>
			 </tr>
		   </thead>
		   <tbody>
			  @foreach ($washes as $wash)
			  <tr>
			  <td>
          <a href="{{ url('/washes/') }}/{{$wash->id}}">{{$wash->title}}</a>
          @if(Auth::check() && Auth::user()->owns($wash->id))
					   <!--<a class="btn btn-danger btn-xs pull-right" href="{{ url('/washes/delete') }}/{{$wash->id}}" role="button">
  						 <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
					   </a>-->
				   @endif
        </td>
			  <td>{{$wash->created_at}}</td>
			  </tr>
			  @endforeach
		  </tbody>
		  </table>
      </div>
 </div>
 </div>
@stop

@section('customjs')

@stop
