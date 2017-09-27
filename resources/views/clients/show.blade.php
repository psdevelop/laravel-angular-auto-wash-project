<div class="col-md-3 col-md-push-9">
  <h3>Опции</h3>
  @if(Auth::check() && (Auth::user()->hasRole('Director')||Auth::user()->hasRole('Manager')))
  <div class="form-group">
    <button type="button" class="btn btn-default" onClick="newClientClickEvent()">
      <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новый клиент
    </button>
  </div>
  @endif
</div>
  <div class="col-md-9 col-md-pull-3">
   <div class="panel-group">
     <div class="panel panel-default" ng-repeat="client in clients">
       <div class="panel-heading" role="tab" id="heading<% client.id %>">
         <h4 class="panel-title">
           <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<% client.id %>" aria-expanded="false" aria-controls="collapse<% client.id %>">
             <strong><% client.name %></strong>
           </a>
           <button class="btn btn-danger btn-xs pull-right" ng-click="deleteClientClickEvent(client.id)" ng-init="count=0">
             <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
           </button>
         </h4>
       </div>
       <div id="collapse<% client.id %>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<% client.id %>">
         <div class="list-group">
           <button type="button" class="list-group-item" ng-click="editClientClickEvent(client.id)" ng-init="count=0">
               <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>&nbsp;Редактировать
           </button>
           <button type="button" class="list-group-item"><span class="glyphicon glyphicon-phone" aria-hidden="true"></span>&nbsp;<% client.phone %></button>
           <button type="button" class="list-group-item"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>&nbsp;<% client.email %></button>
           <button type="button" class="list-group-item">
             <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;Тип оплаты: <% client.paymenttype.title %>
           </button>
           <button type="button" class="list-group-item" ng-repeat="discount in client.discounts">
             <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;Скидкa: <% discount.amount %>%
               <span class="glyphicon glyphicon-trash pull-right" aria-hidden="true" ng-click="deleteClientDiscountClickEvent(client.id, discount.id)" ng-init="count=0"></span>
           </button>
           <button type="button" class="list-group-item" ng-if="client.discounts <= 0" ng-click="newDiscountClickEvent(client.id)" ng-init="count=0">
               <span class="glyphicon glyphicon-tag" aria-hidden="true"></span>&nbsp;Новая скидка
           </button>
           <button type="button" class="list-group-item" ng-click="newAutoClickEvent(client.id)" ng-init="count=0">
               <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>&nbsp;Новое авто
           </button>
           <button type="button" class="list-group-item" ng-repeat="car in client.cars">
             <span class="glyphicon glyphicon-cd" aria-hidden="true"></span>&nbsp;
             <strong>
               <% car.title %>
               <span style="color:#<% car.color.code %>;"><% car.color.title %></span>
             </strong>
           </button>

         </div>
       </div>
     </div>
   </div>

  </div>
