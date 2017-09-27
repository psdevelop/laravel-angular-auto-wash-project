<div class="col-md-3 col-md-push-9">
  <h3>Действия</h3>
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
    <button type="button" class="btn btn-default" onClick="newBoxClickEvent()">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новый бокс
    </button>
  </div>
  @endif
</div>
<div class="col-md-9 col-md-pull-3">
  <div class="col-md-3" ng-repeat="box in boxes">
    <div class="thumbnail">
      <a ng-if="current_ws.washsessions[box.washsession_id] != null" href="#" data-lightbox='gallery'>
        <object class="car-glyph" fill-color="<% current_ws.washsessions[box.washsession_id].car.color.code %>" type="image/svg+xml"
          data="/img/<% current_ws.washsessions[box.washsession_id].car.autotype.icon %>">
        </object>
      </a>
      <a ng-if="current_ws.washsessions[box.washsession_id] == null" href="#"  data-lightbox='gallery'>
         <object class="car-empty" handles='0' type="image/svg+xml" box-id="<% box.id %>" box-worker="<% box.worker_id %>"  data="/img/empty10.svg">
         </object>
      </a>

      <div class="caption">
        <p><strong><% box.title %></strong></p>
        <p ng-if="box.worker_id == 0">Нет оператора</p>
        <p ng-if="box.worker_id != 0"><% box.user.name %></p>

        <div class="progress">
          <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<% current_ws.washsessions[box.washsession_id].complete %>"
            aria-valuemin="0" aria-valuemax="100" style="width: <% current_ws.washsessions[box.washsession_id].complete %>%">
            <% current_ws.washsessions[box.washsession_id].complete %>%
          </div>
        </div>

          <button ng-if="current_ws.washsessions[box.washsession_id] == null" type="button" class="btn btn-default" ng-click="setBoxSelect(box.id)"
                  ng-init="count=0" data-toggle="modal" data-target="#boxloadFormModal">
            Загрузить
          </button>
          <button ng-if="current_ws.washsessions[box.washsession_id] != null" type="button" ng-click="paymentCloseEvent(box)" ng-init="count=0" class="btn btn-default" >
            Завершить
          </button>
          <button type="button" ng-click="editBoxClickEvent(box.id)" ng-init="count=0" class="btn btn-default" >
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
          </button>
          <button type="button" ng-if="box.washsession_id!=0" ng-click="detailWashsessionClickEvent(box.washsession_id)" ng-init="count=0" class="btn btn-default" >
            <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
          </button>
        </div>
      </div>
    </div>
  </div>

  @include('boxes._load',['wash_id'=>$wash->id])
