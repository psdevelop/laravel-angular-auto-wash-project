<form id="boxesReportForm" method="POST" action="{{url('reports/boxes')}}/view">
  {!! csrf_field() !!}
  <input type="hidden" name="wash_id" value="{{$wash_id}}" />
<div class="row">
  <div class="col-md-12">
    <div class="form-group">
      <div class="input-group">
        @foreach($boxes as $box)
        <div class="checkbox-inline">
          <label><input class="boxFlag" name="box_id[]" id="box_id[]" type="checkbox" value="{{ $box->id }}" checked></input>&nbsp;{{ $box->title }}</label>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    {!! Form::label('Period', 'Период: ') !!}
  </div>
</div>

<div class="row">
  <div class="col-md-2">
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" onClick="">От</button>
        </span>
        <input id='period_start' class="form-control" name="period_start" type="date" value="{{Carbon\Carbon::now()->toDateString()}}"></input>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <div class="input-group">
        <span class="input-group-btn">
          <button class="btn btn-default" type="button" onClick="">До</button>
        </span>
        <input id="period_end" class="form-control" name="period_end" type="date" value="{{Carbon\Carbon::now()->toDateString()}}"></input>
      </div>
    </div>
  </div>
  <div class="col-md-2">
    <div class="form-group">
      <div class="input-group">
        {!! Form::submit('Вывести', ['class'=>'btn btn-default', 'type'=>'button']) !!}&nbsp
        <button class="btn btn-default" id="toggleRecords" type="button" onClick="toggleRecordsClickEvent()">
          <span class="glyphicon glyphicon-chevron-down" aria-hidden="true"></span>
        </button>
      </div>
    </div>
  </div>
</div>


</form>
