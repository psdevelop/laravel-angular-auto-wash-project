<div class="col-md-12">
  <div class="table-responsive">
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>/</th>
          <th ng-repeat="auto in autos"><% auto.title %></th>
        </tr>
      </thead>
      <tbody>
        <tr ng-repeat="service in services">
          <td  onClick="markRow(this)"><% service.title %></td>
          <td ng-repeat="auto in autos"
            id="<% service.id %>_<% auto.id %>" service-id="<% service.id %>" auto-type="<% auto.id %>"
            class="right-aligned"
            onClick="priceCellClickEvent(this)">
          </td>
      </tr>
    </tbody>
  </table>
</div>
</div>
