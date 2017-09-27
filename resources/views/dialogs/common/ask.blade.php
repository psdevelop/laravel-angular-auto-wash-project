<!-- Box Modal -->
	<div class="modal fade" id="activeFormModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">{{$title}}</h4>
			</div>
			<form id="activeForm" method="POST" action="{{$execpath}}">
				<div class="modal-body">
					@include('errors.errorlist')
					{!! csrf_field() !!}
					<p>
						{{ $prompt }}
					</p>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
					{!! Form::submit('OK', ['class'=>'btn btn-primary pull-right']) !!}
				</div>
			</form>
		</div>
		</div>
		</div>
	</div>
<!-- END modal -->
