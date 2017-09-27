<form id="dutiesReportForm" method="POST" action="{{url('reports/duties')}}/view">
  {!! csrf_field() !!}
  <input type="hidden" name="wash_id" value="{{$wash_id}}" />

  	<div class="row">
  		<div class="col-md-12">
  			<div class="form-group">
  				<div class="input-group">
  					<div class="form-group">
  					  {!! Form::label('duty_choice', 'Смена: ') !!}
  					  <select name="duty_choice" id="duty_choice" class="form-control" >
                @foreach($duties as $duty)
                  <option value="{{ $duty->id }}">{{ $duty->created_at }}</option>
                @endforeach
  					  </select>
  					</div>
  				</div>
  			</div>
  		</div>
  	</div>


<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <div class="input-group">
        {!! Form::submit('Вывести', ['class'=>'btn btn-default', 'type'=>'button']) !!}
      </div>
    </div>
  </div>
</div>


</form>
