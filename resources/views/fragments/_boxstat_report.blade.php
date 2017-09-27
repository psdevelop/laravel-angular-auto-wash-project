<div class="row">
  <div class="col-md-12">
      {!! Form::label('current_duty', 'Смена: ') !!} {{ $duty->created_at }}
  </div>
</div>

<div class="panel-group">
  <div class="panel panel-default">
    <div class="table-responsive">
    <table class="table table-bordered">
    <thead>
      <tr>
      <th>Бокс</th>
      <th>Оплата</th>
      <th>Марка</th>
      <th>Госномер</th>
      <th>Сумма</th>
      <th>Скидка</th>
      <th>Безнал</th>
    </tr>
    </thead>
    <tbody>
    @foreach($washsessions as $washsession)
     <tr >
       <td><a href="#" onClick="appScope.detailWashsessionClickEvent({{$washsession->id}})">{{ $washsession->box->title }}</a></td>
       <td>{{ $payment->formatCurrency($washsession->payment->render) }}</td>
       <td>{{ $washsession->car->title }}</td>
       <td>{{ $washsession->car->number }}</td>
       <td>{{ $payment->formatCurrency($washsession->payment->total_cost) }}</td>
       <td>{{ $payment->formatCurrency($washsession->local_discount) }}</td>
      @if($washsession->car->user->paymenttype_id == 2)
       <td>{{ $payment->formatCurrency($washsession->payment->total_cost) }}</td>
      @endif
      @if($washsession->car->user->paymenttype_id != 2)
       <td></td>
      @endif
     </tr>
     @endforeach
   </tbody>
   </table>
   </div>
  </div>

</div>
<div class="row">
  <div class="col-md-12">
    <div class="list-group">
      <button type="button" class="list-group-item"><span>Оборот: </span>  &nbsp;p</button>
      <button type="button" class="list-group-item"><span>Зарплата: </span>  &nbsp;p</button>
    </div>
  </div>
</div>
