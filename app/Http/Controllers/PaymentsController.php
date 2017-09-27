<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use App\Service;
use App\Auto;
use App\AutoService;
use App\Payment;
use App\Receipt;

class PaymentsController extends Controller
{
  public function index($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these payments. ";
    }
    // Конец проверки прав пользователя

    // Фильтрация инвойсов по id мойки
    $payments = Payment::whereHas('washsession', function($q) use($id){
         $q->where('wash_id','=', $id)->where('visibility','=',1);
     })->with(['washsession', 'washsession.box', 'washsession.car', 'washsession.car.user'])->orderBy('created_at', 'desc')->get();
    return $payments;
  }

  public function show($payment_id)
  {
    $payment = Payment::with('washsession')->with('washsession.wash')->find($payment_id);
    $wash_key = $payment->washsession->wash->id;
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($wash_key)){
      return "Not allowed to view this payment. ";
    }
    // Конец проверки прав пользователя

    if(isset($payment)){
      $return_html = View::make('dialogs/payments/update',['payment'=>$payment])->render();
    }else{
      $return_html = View::make('dialogs/payments/update',['payment'=>$payment])->render();
    };

    return $return_html;
  }

  public function update(Request $request)
  {
    $input = $request->all();
    $edit_payment = Payment::with('washsession.wash')->find($input['payment_id']);

    $wash_key = $edit_payment->washsession->wash->id;
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($wash_key)){
      return "Not allowed to update this payment. ";
    }
    // Конец проверки прав пользователя

    $payment = Payment::with('washsession')->find($input['payment_id']);
    $addition = $payment->render + $input['addition'];
    if($addition > ($payment->total_cost - $payment->washsession->local_discount)) $addition = ($payment->total_cost - $payment->washsession->local_discount);
    $payment->render = $addition;
    $payment->save();

    $receipt = new Receipt;
    $receipt->payment_id = $payment->id;
    $receipt->comment = "Оплата за услуги.";
    $receipt->amount =  $input['addition'];
    $receipt->save();

    return "Payment update OK.";
  }
}
