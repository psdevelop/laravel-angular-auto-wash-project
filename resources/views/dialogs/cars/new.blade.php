<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Добавить авто</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('cars')}}/save">
			<div class="modal-body">
			@include('errors.errorlist')
			{!! csrf_field() !!}
			<div class="form-group">
			{!! Form::label('title', 'Марка: ') !!}
			{!! Form::text('title', null, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
			{!! Form::label('number', 'Гос. Номер: ') !!}
			{!! Form::text('number', null, ['class'=>'form-control']) !!}
			</div>
			<div class="form-group">
				{!! Form::label('autotype_id', 'Тип авто: ') !!}
				<select name="auto_id" class="form-control">
					@foreach($auto_types as $auto_type)
						<option value="{{$auto_type->id}}">{{$auto_type->title}}</option>
					@endforeach
				</select>
			</div>
			<div class="form-group">
				{!! Form::label('color_id', 'Цвет: ') !!}
				<select name="color_id" class="form-control">
					@foreach($colors as $color)
						<option value="{{$color->id}}" style="color:#{{$color->code}}">{{$color->title}}</option>
					@endforeach
				</select>
			</div>
			{!! Form::hidden('wash_id', $wash_id, ['class'=>'form-control']) !!}
			{!! Form::hidden('user_id', $client_id, ['class'=>'form-control']) !!}
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
