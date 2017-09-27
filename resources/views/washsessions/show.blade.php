
<div class="col-md-12">
  <div class="panel-group">
    <div class="panel panel-default" ng-repeat="washsession in washsessions.washsessions | orderBy:$index">
      <div class="panel-heading" role="tab" id="heading<% washsession.id %>">
        <h4 class="panel-title">
          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<% washsession.id %>" aria-expanded="false" aria-controls="collapse<% washsession.id %>">
            <strong>
              <% washsession.started_at %>
              <span class="pull-right"><% formatCurrency(washsession.payment.total_cost) %>&nbsp;p.</span>
            </strong>
          </a>
        </h4>
      </div>
      <div id="collapse<% washsession.id %>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<% washsession.id %>">
        <div class="list-group">
          <button type="button" class="list-group-item"><% washsession.box.title %></button>
          <button type="button" class="list-group-item">Клиент: <% washsession.car.user.name %></button>
          <button type="button" class="list-group-item"><% washsession.car.user.phone %></button>
          <button type="button" class="list-group-item">Тип авто: <% washsession.car.autotype.title %></button>
          <button type="button" class="list-group-item">Открыт: <% washsession.started_at %></button>
          <button type="button" ng-if="washsession.complete>=100" class="list-group-item">Завершён: <% washsession.finished_at %></button>
          <button type="button" ng-if="washsession.complete<100" class="list-group-item">Выполнение: <% washsession.complete %>%</button>
          <button type="button" ng-if="washsession.discount" class="list-group-item">Скидка: <% washsession.discount.amount %>%</button>
        </div>
        <table class="table table-responsive">
          <thead>
            <tr>
              <th>Название</th>
              <th>цена / p.</th>
            </tr>
          </thead>
          <tbody>
            <tr ng-repeat="washservice in washsession.washservices">
              <td><% washservice.autoservice.service.title %></td>
              <td><% formatCurrency(washservice.cost) %> </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
