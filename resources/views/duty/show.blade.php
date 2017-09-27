<div class="col-md-3 col-md-push-9">
  <h3>Итого:</h3>
  <p>Сумма: <% formatCurrency(total_washsessions_summ) %> р.</p>
  <p>Скидки: <% formatCurrency(total_washsessions_discounts) %> р.</p>
  <p>Безнал: <% formatCurrency(total_washsessions_nocash) %> р.</p>
  <div class="form-group">
    <button type="button" class="btn btn-default" onClick="currentSalaryClickEvent()">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Зарплата
    </button>
  </div>
  <h3>Опции</h3>
  @if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
  <div class="form-group" ng-if="wash.duty_id == 0">
    <button type="button" class="btn btn-default" onClick="openDutyClickEvent()">
      <span class="glyphicon glyphicon-check" aria-hidden="true"></span>&nbsp;Открыть смену
    </button>
  </div>
  <div class="form-group" ng-if="wash.duty_id != 0">
    <button type="button" class="btn btn-default" ng-click="closeDutyClickEvent(washId)" ng-init="count=0">
      <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Закрыть смену
    </button>
  </div>
  <div class="form-group">
    <button type="button" class="btn btn-default" onClick="newDutyClickEvent()">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новая смена
    </button>
  </div>
  @endif
</div>
  <div class="col-md-9 col-md-pull-3">
   <div class="table-responsive">
   <table class="table table-bordered">
   <thead>
     <tr>
	   <th>Бокс</th>
	   <th>Оплата</th>
     <th>Марка</th>
	   <th>Госномер</th>
	   <th>Сумма</th>
     <th>Скидка</th>
     <th>Безнал</th>
	 </tr>
   </thead>
   <tbody>
    <tr ng-repeat="washsession in duty_washsessions">
	    <td><a href="#" ng-click="detailWashsessionClickEvent(washsession.id)" ng-init="count=0"><% washsession.box.title %></a></td>
      <td><% formatCurrency(washsession.payment.render) %></td>
      <td><% washsession.car.title %></td>
      <td><% washsession.car.number %></td>
      <td><% formatCurrency(washsession.payment.total_cost) %></td>
      <td><% formatCurrency(washsession.local_discount) %></td>
      <td ng-if="washsession.car.user.paymenttype_id==2"><% formatCurrency(washsession.payment.total_cost) %></td>
      <td ng-if="washsession.car.user.paymenttype_id!=2"></td>
	  </tr>
  </tbody>
  </table>
  </div>
  </div>
