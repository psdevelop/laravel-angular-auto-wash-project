<div class="col-md-12">
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<div class="input-group">
					<div class="form-group">
					  {!! Form::label('report_type', 'Тип отчёта: ') !!}
					  <select name="report_type" id="report_type" class="form-control" onChange="reportTypeChangeEvent()">
							<option value="0" selsected>---</option>
							<option value="5">Статистика боксов</option>
							@if(false)
							  <option value="1">Сверка по боксам</option>
							  <option value="3">Безналичные расчёты</option>
								<option value="2">Сверка по клиентам</option>
							@endif
							<option value="4">Сверка по сменам</option>
					  </select>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="report_parameters">
	</div>
  <div id="report_view">
	</div>

</div>
