<div class="row">
  <div class="col-md-12">
      {!! Form::label('total_profit', 'Клиент: ') !!} {{ $client->name }}
  </div>
</div>
<div class="panel-group">
  @foreach($washsessions as $washsession)
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingRecord{{ $washsession->id }}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseRecord{{ $washsession->id }}" aria-expanded="false" aria-controls="collapseRecord{{ $washsession->id }}">
          <strong>
            {{ $washsession->created_at }}
            <span class="pull-right"> {{ $payment->formatCurrency($washsession->payment->render) }} &nbsp;p.</span>
          </strong>
        </a>
      </h4>
    </div>
    <div id="collapseRecord{{ $washsession->id }}" class="panel-collapse in" role="tabpanel" aria-labelledby="headingRecord{{ $washsession->id }}">
      <div class="list-group">
        <button type="button" class="list-group-item"><span>Оплачено: </span>  {{ $payment->formatCurrency($washsession->payment->render) }}&nbsp;p</button>
        <button type="button" class="list-group-item"><span>Стоимость: </span>  {{ $payment->formatCurrency($washsession->payment->total_cost) }}&nbsp;p</button>
        <button type="button" class="list-group-item"><span>Оператор: </span>  {{ $washsession->user->name }}</button>
        <button type="button" class="list-group-item"><span>Бокс: </span>  {{ $washsession->box->title }}</button>
        @if(isset($washsession->discount))
        <button type="button" class="list-group-item">
          <span>Скидка: </span> {{ $washsession->discount->amount }}  &nbsp;%
        </button>
        @endif
      </div>
      <div class="table-responsive">
        <table class="table table-responsive">
          <thead>
            <tr>
              <th>Услуга</th>
              <th>Стоимость, p</th>
            </tr>
          </thead>
          <tbody>
            @foreach($washsession->washservices as $washservice)
            <tr>
              <td onClick="markRow(this)">{{ $washservice->autoservice->service->title }}</td>
              <td>{{ $payment->formatCurrency($washservice->cost) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endforeach
</div>
