<div class="form-group"> 
{!! Form::label('auto_service_id', 'Услуга: ') !!}
  <select name="autotype_id" class="form-control">
    @foreach($auto_services as $auto_service)
      <option value="{{$auto_service->id}}">{{$auto_service->service->title}} [{{$auto_service->auto->title}}]</option>
	@endforeach
  </select>		
</div>				  