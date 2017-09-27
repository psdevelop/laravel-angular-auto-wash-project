<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;

use App\Receipt;
use App\Expence;
use App\User;
use App\Role;

use View;

class CashboxController extends Controller
{
  public function receipts($wash_id){

    $receipts = Receipt::whereHas('payment.washsession', function($q)use($wash_id){
      $q->where('wash_id','=', $wash_id);
    })->get();

    return $receipts;
  }

  public function expences($wash_id){

    $expences = Expence::whereHas('user',function($q)use($wash_id){
      $q->where('wash_id','=', $wash_id);
    })->get();

    return $expences;
  }

  public function newExpence($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to add new expence. ";
    }
    // Конец проверки прав пользователя
    $receipts = Receipt::whereHas('payment.washsession', function($q)use($id){
      $q->where('wash_id','=', $id);
    })->get();
    $totalReceipts = 0;

    foreach($receipts as $receipt){
      $totalReceipts += $receipt->amount;
    }

    $expences = Expence::whereHas('user',function($q)use($id){
      $q->where('wash_id','=', $id);
    })->get();
    $totalExpences = 0;

    foreach($expences as $expence){
      $totalExpences += $expence->amount;
    }

    $workers = User::where('wash_id','=',$id)->where('visibility','=',1)->with('role')->whereIn('role_id',array(Role::operator()->id , Role::manager()->id))->get();

    $return_html = View::make('dialogs/expences/new', ['cashboxTotal'=>($totalReceipts-$totalExpences), 'employees'=>$workers])->render();

    return $return_html;
  }

  public function create(Request $request)
  {
    $input = $request->all();

    $new_expence = new Expence;
    $new_expence->user_id = Auth::user()->id;
    $new_expence->amount = $input['amount'];
    $new_expence->receiver_id = $input['receiver_id'];
    $new_expence->comment = $input['comment'];

    $new_expence->save();
  }
}
