<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Новый тип смены</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('duties')}}/save">
				<div class="modal-body">
					@include('errors.errorlist')
					{!! csrf_field() !!}
					<div class="form-group">
						{!! Form::label('title', 'Заголовок смены: ') !!}
						{!! Form::text('title', null, ['class'=>'form-control']) !!}
					</div>
					<div class="form-group">
						{!! Form::label('salary_perc', 'Процент зарплаты: ') !!}
						{!! Form::text('salary_perc', null, ['class'=>'form-control']) !!}
					</div>
					{!! Form::hidden('wash_id', $wash_id, ['class'=>'form-control']) !!}
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					{!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
				</div>
			</form>
		</div>
		</div>
	</div>
<!-- END modal -->
