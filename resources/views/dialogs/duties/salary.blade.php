<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Зарплата ({{$duty->dutytype->salary_perc}}% за смену)</h4>
			</div>
			<form id="activeForm" method="POST" action="#">
				<div class="modal-body">
					<div class="table-responsive">
			    <table class="table table-bordered">
			    <thead>
			      <tr>
			 	   <th>Бокс</th>
			 	   <th>Сумма, р.</th>
			 	   <th>Зарплата, р.</th>
			 	 </tr>
			    </thead>
					<tbody>
						@for($i = 0; $i < count($boxes); ++$i)
						<tr>
							<td onClick="markRow(this)">{{ $boxes[$i]->title }}</td>
							<td>{{  $total_summs[$i] }}</td>
							<td>{{  $salaries[$i] }}</td>
						</tr>
						@endfor
					</tbody>
			   </table>
			   </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					{!! Form::submit('Ok', ['class'=>'btn btn-primary']) !!}
				</div>
			</form>
		</div>
		</div>
	</div>
<!-- END modal -->
