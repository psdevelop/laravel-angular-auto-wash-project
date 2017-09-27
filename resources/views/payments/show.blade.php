<div class="col-md-12">
<div class="table-responsive">
	<table class="table table-bordered">
		<thead>
			<tr>
				<th>Дата</th>
				<th>Клиент</th>
				<th>Бокс</th>
				<th>К оплате (р.)</th>
				<th>Оплачено (р.)</th>
			</tr>
		</thead>
		<tbody>

			<tr ng-repeat="payment in payments">
				<td  onClick="markRow(this)"><% payment.created_at %></td>
				<td><% payment.washsession.car.user.name %></td>
				<td><% payment.washsession.box.title %></td>
				<td><% formatCurrency(payment.total_cost - payment.washsession.local_discount) %></td>
				<td payment-id="<% payment.id %>" onClick="paymentCellClickEvent(this)">
					<% formatCurrency(payment.render) %>
				</td>
			</tr>
		</tbody>
	</table>
</div>
</div>
