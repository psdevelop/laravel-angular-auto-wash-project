<!-- Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Новый тип авто</h4>
			</div>
			<form id="activeForm" method="POST" action="{{url('autos')}}/updateAuto">
			<div class="modal-body">
			@include('errors.errorlist')
			{!! csrf_field() !!}
			<div class="form-group">
				{!! Form::label('title', 'Наименование типа: ') !!}
				{!! Form::text('title', $auto->title, ['class'=>'form-control' ]) !!}
			</div>
			<input type="hidden" name="auto_id" id="auto_id" value="{{ $auto->id }}" />
			<input type="hidden" name="icon" id="icon" value="{{ $auto->icon }}" />

			</div>
			<div class="form-group">
				{!! Form::label('title', 'Пиктограмма: ') !!}
				<div id="iconCarousel" class="carousel slide"  data-interval="false">
					<div class="carousel-inner">
						<div class="item active thumbnail">
							<img src="/img/middle.svg" icon-data="middle.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/cross.svg" icon-data="cross.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/import.svg" icon-data="import.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/microbus.svg" icon-data="microbus.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/mini.svg" icon-data="mini.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/gruz.svg" icon-data="gruz.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/moto.svg" icon-data="moto.svg" />
						</div>
						<div class="item thumbnail">
							<img src="/img/bus.svg" icon-data="bus.svg" />
						</div>

					</div>
					<!-- Controls -->
					<a class="left carousel-control" href="#iconCarousel" role="button" data-slide="prev">
						<span class="glyphicon glyphicon-chevron-left"></span>
					</a>
					<a class="right carousel-control" href="#iconCarousel" role="button" data-slide="next">
						<span class="glyphicon glyphicon-chevron-right"></span>
					</a>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
				{!! Form::submit('Сохранить', ['class'=>'btn btn-primary']) !!}
			</div>
			</form>
		</div>
		</div>
		</div>
	</div>
<!-- END modal -->
