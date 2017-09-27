@extends('app')


@section('content')
@if(isset($box))
<div class="container" ng-app="boxControllerApp" ng-controller="boxController">
  <div class="row">
    <div id="dialogWall" >
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" id="washId" value="{{$box->wash->id}}" />
      <input type="hidden" id="boxId" value="{{$box->id}}" />

    </div>
  </div>
  <!-- Область контента -->
  <div class="tab-content separated">

    @include('boxes.process',['box_id'=>$box->id])

  </div>
</div>
@else
<div class="container">
  <div class="row">
  <h3>Вам не назначен бокс. Обратитесь к менеджеру.</h3>
</div>
<div>
@endif
@stop

@section('customjs')
  <script src="{{url('/')}}/js/angular/angular.min.js"></script>
  <script src="{{url('/')}}/js/controllers/boxes/BoxesController.js"></script>
@stop
