<div class="row">
  <div class="col-md-12">
      {!! Form::label('total_profit', 'Общий доход: ') !!} {{ $payment->formatCurrency($total_profit) }}&nbsp;р.
  </div>
</div>
<div class="panel-group">
  @foreach($boxes as $box)
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingRecord{{ $box->id }}">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseRecord{{ $box->id }}" aria-expanded="false" aria-controls="collapseRecord{{ $box->id }}">
          <strong>
            {{ $box->title }}
            <span class="pull-right"> {{ $payment->formatCurrency($box->total_profit) }} &nbsp;p.</span>
          </strong>
        </a>
      </h4>
    </div>
    <div id="collapseRecord{{ $box->id }}" class="panel-collapse in" role="tabpanel" aria-labelledby="headingRecord{{ $box->id }}">
      <div class="list-group">
        <button type="button" class="list-group-item"><span>Оборот: </span> {{ $payment->formatCurrency($box->total_income) }} &nbsp;p</button>
        <button type="button" class="list-group-item"><span>Зарплата: </span> {{ $payment->formatCurrency($box->total_salary) }} &nbsp;p</button>
      </div>
      <div class="table-responsive">
        <table class="table table-responsive">
          <thead>
            <tr>
              <th>К оплате, р</th>
              <th>Получено, р</th>
              <th>Скидка</th>
              <th>Авто</th>
              <th>Дата</th>
              <th>Владелец</th>
              <th>Оператор</th>
            </tr>
          </thead>
          <tbody>
            @foreach($box->washsessions as $washsession)
            <tr>
              <td onClick="markRow(this)">{{ $payment->formatCurrency($washsession->payment->total_cost) }}</td>
              <td>{{ $payment->formatCurrency($washsession->payment->render) }}</td>
              <td>@if(isset($washsession->local_discount)){{ $payment->formatCurrency($washsession->local_discount) }}@endif</td>
              <td>{{ $washsession->car->title }} [ {{ $washsession->car->number }} ]</td>
              <td>{{ $washsession->created_at }}</td>
              <td>{{ $washsession->car->user->name }}</td>
              <td>{{ $washsession->user->name }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
  @endforeach
</div>
