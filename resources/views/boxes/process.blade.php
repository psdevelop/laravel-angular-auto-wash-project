   <div class="col-md-3 col-md-push-9">
   </div>
   <div class="col-md-9 col-md-pull-3">
      <div class="col-md-4">
        <div class="thumbnail">
          <a ng-if="washsession.auto != null" href="#" data-lightbox='gallery'><img src="/img/<% washsession.auto.icon %>" alt='111' /></a>
          <a ng-if="washsession.auto == null" ng-click="setBoxSelect(box.id)" ng-init="count=0" href="#" data-toggle="modal"  data-target="#boxloadFormModal"  data-lightbox='gallery'>
            <img src="/img/empty.png" alt='111' />
          </a>
          <div class="caption">
            <p><strong><% box.title %></strong></p>
            <p ng-if="box.worker_id == 0">Нет оператора</p>
            <p ng-if="box.worker_id != 0"><% box.user.name %></p>

            <div class="progress">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<% washsession.complete %>"
              aria-valuemin="0" aria-valuemax="100" style="width: <% washsession.complete %>%"><% washsession.complete %>%</div>
            </div>

            <button ng-if="washsession.auto == null" type="button" class="btn btn-default" ng-click="setBoxSelect(box.id)" ng-init="count=0" data-toggle="modal" data-target="#boxloadFormModal">
              <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Загрузить
            </button>
            <button ng-if="washsession.auto != null" type="button" ng-click="freeBox(box.id)" ng-init="count=0" class="btn btn-default" >
              <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>&nbsp;Освободить
            </button>
          </div>
        </div>
      </div>
  </div>

  <!-- Washsession Modal -->
   <div class="modal fade" id="boxloadFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
     <div class="modal-dialog" role="document">
       <div class="modal-content">
         <div class="modal-header">
           <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
           <h4 class="modal-title" id="boxloadModalLabel">
             <span class="glyphicon glyphicon-scale" aria-hidden="true"></span>&nbsp;<% box.user.name %>
           </h4>
           <h3>
             Загрузить бокс<br />
           </h3>
           <span >&nbsp;<% box.title %></span>
         </div>
         <form id="boxloadForm" method="POST" action="{{url('washsessions')}}/createWashsession">
           <div class="modal-body">
             @include('errors.errorlist')
             {!! csrf_field() !!}
             <input name="wash_id" type="hidden" id="wash_id" value="<% box.wash.id %>" />
             <input name="box_id" type="hidden" id="box_id" value="<% box.id %>" />
             <div class="form-group">
               {!! Form::label('start_date', 'Дата: ') !!}
               <input id="bxDate" class="form-control" name="start_date" type="date" value="<% curNow | date:'yyyy-MM-dd' %>"></input>
             </div>
             <div class="form-group">
               {!! Form::label('start_time', 'Время: ') !!}
               <input id="bxTime" class="form-control" name="start_time" type="time" value="<% curNow | date:'HH:mm' %>"></input>
             </div>
             <div class="form-group">
               {!! Form::label('autotype_id', 'Тип авто: ') !!}
               <select ng-model="auto_select" name="autotype_id" class="form-control">
                 <option ng-repeat="auto in box.autos" value="<% auto.id %>"><% auto.title %></option>
               </select>
             </div>
             <div class="form-group">
               {!! Form::label('service_add', 'Добавить услугу: ') !!}
             </div>
             <div class="form-group">
               <div class="form-inline">
                 <select name="service_select" class="form-control" id="service_selector">
                   <option ng-repeat="auto_service in box.auto_services | filter:{auto_id: auto_select}"
                   value="<% auto_service.id %>"><% auto_service.service.title %> [ <% auto_service.timing %> ] [ = <% formatCurrency(auto_service.cost) %> p.]</option>
                 </select>
                 <button type="button" class="btn btn-default pull-right" onClick="appendService()">
                   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                 </button>
               </div>
             </div>
             <div class="form-group">
               {!! Form::label('service_list', 'Набор услуг: ') !!}
               <ul class="list-group" id="services-bay">
                 <li class="list-group-item" ng-repeat="as in auto_servicesList track by $index">
                   <button type="button" class="btn btn-default btn-xs" onClick="removeService(this)" key-value="<% $index %>" href="<% $index %>">
                     <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
                   </button>

                   <% as.service.title %>
                   <strong class="pull-right"><% formatCurrency(as.cost) %> р.</strong>
                   <input name="autoservice_id[<% $index %>]" type="hidden" id="autoservice_id[<% $index %>]" value="<% as.id %>" />
                 </li>
               </ul>
             </div>
             <div class="form-group">
               <strong>Время: <span><% total_timing %> мин.</span></strong>
             </div>
             <div class="form-group">
               <strong class="total-price">Цена: <span><% formatCurrency(total_price) %> р.</span></strong>
               <input name="total_cost" type="hidden" id="total_cost" value="<% total_price %>" />
               <input name="total_timing" type="hidden" id="total_timing" value="<% total_timing %>" />
             </div>
           </div>
           <div class="modal-footer">
             <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Отмена</button>
             {!! Form::submit('Сохранить', ['class'=>'btn btn-primary pull-right']) !!}
           </div>
         </form>
       </div>
     </div>
   </div>
   <!-- END modal -->
