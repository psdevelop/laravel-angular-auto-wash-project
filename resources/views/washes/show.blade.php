@extends('app')

@section('content')
<div class="container-fluid" ng-app="washesControllerApp" ng-controller="washesController">
  <div class="row">
    <div id="dialogWall" >
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <input type="hidden" id="washId" value="{{$wash->id}}" />
      <!-- Закладки навигации -->
      <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active">
          <a href="#boxes" aria-controls="boxes" role="tab" data-toggle="tab" id="boxesFrame">Боксы</a>
        </li>
        <li role="presentation">
          <a href="#duty" aria-controls="duty" role="tab" data-toggle="tab" id="dutyFrame">Смена</a>
        </li>
        <li role="presentation">
          <a href="#records" aria-controls="records" role="tab" data-toggle="tab" id="recordsFrame">Отчёты</a>
        </li>
        <li role="presentation">
          <a href="#payments" aria-controls="payments" role="tab" data-toggle="tab" id="paymentsFrame">Оплата</a>
        </li>
        <!--<li role="presentation">
          <a href="#washsessions" aria-controls="washsessions" role="tab" data-toggle="tab" id="washsessionsFrame">Сеансы</a>
        </li>-->
        <li role="presentation">
          <a href="#prices" aria-controls="prices" role="tab" data-toggle="tab" id="pricesFrame">Прайс</a>
        </li>
        <li role="presentation">
          <a href="#services" aria-controls="services" role="tab" data-toggle="tab" id="servicesFrame">Услуги</a>
        </li>
        <li role="presentation">
          <a href="#autos" aria-controls="autos" role="tab" data-toggle="tab" id="autosFrame">Типы авто</a>
        </li>
        <li role="presentation">
          <a href="#subordinates" aria-controls="subordinates" role="tab" data-toggle="tab" id="subordinatesFrame">Сотрудники</a>
        </li>
        <li role="presentation">
          <a href="#clients" aria-controls="clients" role="tab" data-toggle="tab" id="clientsFrame">Клиенты</a>
        </li>
        <li role="presentation">
          <a href="#cashbox" aria-controls="cashbox" role="tab" data-toggle="tab" id="cashboxFrame">Касса</a>
        </li>
      </ul>
    </div>
  </div>
  <!-- Область контента -->
  <div class="tab-content separated">
    <div role="tabpanel" class="tab-pane fade in active" id="boxes">
      @include('boxes.show',['wash_id'=>$wash->id])
    </div>
    <div role="tabpanel" class="tab-pane fade" id="payments">
      @include('payments.show')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="duty">
      @include('duty.show')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="records">
      @include('records.show')
    </div>
    <div role="tabpanel" class="tab-pane fade" id="prices">
      @include('prices.show')
    </div>
    <!--<div role="tabpanel" class="tab-pane fade" id="washsessions">
      @include('washsessions.show',['wash'=>$wash])
    </div>-->
    <div role="tabpanel" class="tab-pane fade" id="services">
      @include('services.show',['wash_id'=>$wash->id])
    </div>
    <div role="tabpanel" class="tab-pane fade" id="autos">
      @include('autos.show',['wash_id'=>$wash->id])
    </div>
    <div role="tabpanel" class="tab-pane fade" id="subordinates">
      @include('users.show',['wash_id'=>$wash->id])
    </div>
    <div role="tabpanel" class="tab-pane fade" id="clients">
      @include('clients.show',['wash_id'=>$wash->id])
    </div>
    <div role="tabpanel" class="tab-pane fade" id="cashbox">
      @include('cashbox.show',['wash_id'=>$wash->id])
    </div>
  </div>

</div>
@stop

@section('customjs')
  <script src="{{url('/')}}/js/angular/angular.js"></script>
  <script src="{{url('/')}}/js/controllers/Controller.js"></script>
  <script src="{{url('/')}}/js/controllers/washsessions/WashsessionsController.js"></script>
  <script src="{{url('/')}}/js/controllers/washsessions/WashsessionsEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/payments/PaymentsController.js"></script>
  <script src="{{url('/')}}/js/controllers/payments/PaymentsEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/users/UsersController.js"></script>
  <script src="{{url('/')}}/js/controllers/users/UsersEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/prices/PricesController.js"></script>
  <script src="{{url('/')}}/js/controllers/prices/PricesEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/autos/AutosController.js"></script>
  <script src="{{url('/')}}/js/controllers/autos/AutosEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/services/ServicesController.js"></script>
  <script src="{{url('/')}}/js/controllers/services/ServicesEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/boxes/BoxesController.js"></script>
  <script src="{{url('/')}}/js/controllers/boxes/BoxesEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/receipts/ReceiptsController.js"></script>
  <script src="{{url('/')}}/js/controllers/receipts/ReceiptsEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/expences/ExpencesController.js"></script>
  <script src="{{url('/')}}/js/controllers/expences/ExpencesEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/washes/WashesController.js"></script>
  <script src="{{url('/')}}/js/controllers/washes/WashesEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/cars/CarsController.js"></script>
  <script src="{{url('/')}}/js/controllers/cars/CarsEvents.js"></script>
  <script src="{{url('/')}}/js/controllers/duties/DutiesController.js"></script>
  <script src="{{url('/')}}/js/controllers/duties/DutiesEvents.js"></script>
@stop
