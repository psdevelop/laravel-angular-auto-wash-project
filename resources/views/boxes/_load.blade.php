  <!-- Washsession Modal -->
  <div class="modal fade" id="boxloadFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="boxloadModalLabel">
            <span class="glyphicon glyphicon-scale" aria-hidden="true"></span>&nbsp;{{$wash->title}}
          </h4>
          <h3>
            Загрузить бокс<br />
          </h3>
          <!--<span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span>&nbsp;Бокс: <% box_select %>&nbsp;₽<br />-->
          <span>&nbsp;<% washsessions.current_time %></span>
        </div>
        <form id="boxloadForm" method="POST" action="{{url('washsessions')}}/createWashsession">
          <div class="modal-body">
            @include('errors.errorlist')
            {!! csrf_field() !!}
            <input name="wash_id" type="hidden" id="wash_id" value="{{$wash->id}}" />
            <input name="box_id" type="hidden" id="box_id" value="<% box_select %>" />
            <input name="car_id" type="hidden" id="car_id" value="<% car_select %>" />
            <input name="duty_id" type="hidden" id="car_id" value="<% wash.duty_id %>" />
            <input name="custom_service_count" type="hidden" id="custom_service_count" value="<% custom_service_count %>" />
            <input name="order_switch" type="hidden" id="order_switch" value="0" />
            <!--<div class="form-group">
              {!! Form::label('box_id', 'Бокс: ') !!}
              <select ng-model="box_select" name="box_id" class="form-control">
                <option ng-repeat="box in boxes" value="<% box.id %>"><% box.title %></option>
              </select>
            </div>-->
            <div class="form-group">
      				<div class="input-group">
              {!! Form::text('client_key', null, ['id'=>'client_key', 'class'=>'form-control', 'onInput'=>'searchClient(this)']) !!}
                <span class="input-group-btn">
                  <button class="btn btn-default" type="button" onClick="searchClient('#client_key')"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
                </span>
              </div>
      			</div>
            <div ng-if="(found_clients.length > 0)||(found_cars.length > 0)" class="list-group">
              <div class="panel-group">
                <div class="panel panel-default" ng-repeat="car in found_cars">
                  <button type="button" onClick="markPlate()" class="list-group-item" ng-click="setWashsessionParameters(car)" ng-init="count=0">
                    <span class="glyphicon glyphicon-cd"></span>&nbsp;<span style="color:#<% car.color.code %>"><% car.title %></span>&nbsp;<strong><% car.number %></strong>
                  </button>
                </div>
                <div class="panel panel-default" ng-repeat="client in found_clients">
                  <div class="panel-heading" role="tab" id="heading<% client.id %>">
                    <h4 class="panel-title">
                      <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<% client.id %>" aria-expanded="false" aria-controls="collapse<% client.id %>">
                        <span class="glyphicon glyphicon-user"></span>&nbsp;<strong><% client.name %></strong>
                      </a>
                    </h4>
                  </div>
                  <div id="collapse<% client.id %>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<% client.id %>">
                    <div class="list-group">
                        <button type="button" onClick="markPlate()" class="list-group-item" ng-repeat="car in client.cars" ng-click="setWashsessionParameters(car)" ng-init="count=0">
                          <span ng-click="setWashsessionParameters(car)" ng-init="count=0">
                            <span class="glyphicon glyphicon-cd"></span>&nbsp;<% car.title %> <span style="color:#<% car.color.code %>"><% car.color.title %></span>
                          </span>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div ng-show="(found_clients.length <= 0)&&(found_cars.length <= 0)" class="form-group">
              <div class="form-group">
                {!! Form::label('service_add', 'Новый клиент: ') !!}
              </div>
              <div class="form-group">
                {!! Form::label('new_client_phone', 'Телефон: ') !!}
                {!! Form::text('new_client_phone', null, ['class'=>'form-control', 'onInput'=>'switchToForm()']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('new_client_name', 'Имя: ') !!}
                {!! Form::text('new_client_name', null, ['class'=>'form-control', 'onInput'=>'switchToForm()']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('new_client_email', 'Email: ') !!}
                {!! Form::text('new_client_email', null, ['class'=>'form-control', 'onInput'=>'switchToForm()']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('title', 'Марка: ') !!}
                {!! Form::text('title', null, ['class'=>'form-control']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('number', 'Гос. Номер: ') !!}
                {!! Form::text('number', null, ['class'=>'form-control']) !!}
              </div>
              <div class="form-group">
                {!! Form::label('new_client_autotype_id', 'Тип авто: ') !!}
                <select ng-model="auto_select" name="autotype_id" class="form-control" ng-change="resetServices()">
                  <option ng-repeat="auto in autos" value="<% auto.id %>"><% auto.title %></option>
                </select>
              </div>
              <div class="form-group">
        				{!! Form::label('color_id', 'Цвет: ') !!}
        				<select name="color_id" class="form-control">
        						<option ng-repeat="color in colors" value="<% color.id %>" style="color:#<% color.code %>"><% color.title %></option>
        				</select>
        			</div>
            </div>
            <div class="form-group">
              {!! Form::label('service_add', 'Набор услуг: ') !!}
            </div>
              <ul class="list-group" id="selectedServicesList">
                <li onclick="toggleServiceCheckBox(this)" class="list-group-item" ng-repeat="auto_service in auto_services | filter:{auto_id: auto_select} track by $index">
                  <% auto_service.service.title %>
                  <input class="input-xs" name="new_autoservice_cost[auto_service.id]"
                     size=4 id="new_autoservice_cost[auto_service.id]" type="text"
                     ng-model="auto_service.cost"
                     ng-change="editService(auto_service.id, auto_service.cost)"
                     value="<% formatCurrency(auto_service.cost) %>">
                   </input>p.
                  <strong > / <% formatCurrency(auto_service.cost) %> р.</strong>
                    <span class="checkmark glyphicon glyphicon-ok pull-right" style="display:none;"></span>
                  <span class="pull-right"><input name="autoservice_id[<% $index %>]" id="autoservice_id[<% $index %>]" type="checkbox" style="display:none;" value="<% auto_service.id %>"></input></span>
                  <input name="autoservice_cost[<% $index %>]" type="hidden" id="autoservice_cost[<% $index %>]" value="<% auto_service.cost %>" />
                </li>
                <li class="list-group-item">
                  Прочие услуги:
                  <a href="#" style="margin-left:1em; margin-right:1em;" class="btn btn-danger btn-xs" onClick="removeCustomService()">
                  <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                </a>
                  <a href="#" class="btn btn-danger btn-xs" onClick="appendCustomService()">
                  <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                 </a>
                </li>
                <li class="list-group-item" id="services_custom_end">
                  Скидка за сеанс:
                  <input class="input-xs" ng-model="washsession_discount" ng-change="recalculateTotals()" name="washsession_discount" size=4 id="washsession_discount" type="text" value="0" ></input>&nbsp;p.
                </li>
              </ul>
            <div class="form-group">
              <strong>Время: <span><% total_timing %> мин.</span></strong>
            </div>
            <div class="form-group" ng-if="discounts.length>0">
              Скидка: <% discounts[0].amount %>%
            </div>
            <div class="form-group" ng-if="discounts.length>0">
              <strong class="total-price" >Стоимость: <span><% formatCurrency(raw_price) %> р.</span></strong>
            </div>
            <div class="form-group" ng-if="discounts.length>0">
              <strong class="total-price" ng-if="discounts.length>0">Скидка: <span><% discounts[0].amount %>%</span></strong>
            </div>
            <div class="form-group">
              <strong class="total-price">Цена: <span><% formatCurrency(combined_price) %> р.</span></strong>
              <input name="total_cost" type="hidden" id="total_cost" value="<% total_price %>" />
              <input name="total_timing" type="hidden" id="total_timing" value="<% total_timing %>" />
            </div>
            <div class="form-group">
              {!! Form::label('start_date', 'Дата: ') !!}
              <input id="bxDate" class="form-control" name="start_date" type="date" value="<% curNow | date:'yyyy-MM-dd' %>"></input>
            </div>
            <div class="form-group">
              {!! Form::label('start_time', 'Время: ') !!}
              <input id="bxTime" class="form-control" name="start_time" type="time" value="<% curNow | date:'HH:mm' %>"></input>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
            {!! Form::submit('Сохранить', ['class'=>'btn btn-primary pull-right ws_submit']) !!}
          </div>
        </form>
      </div>
    </div>
  </div>
  <!-- END modal -->
