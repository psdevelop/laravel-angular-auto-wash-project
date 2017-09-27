<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use App\Discount;
use App\User;

class DiscountsController extends Controller
{
  public function create($id, $client_id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to create discounts for this client. ";
    }
    // Конец проверки прав пользователя
    $return_html = View::make('dialogs/discounts/new',['wash_id'=>$id, 'client_id'=>$client_id])->render();
    return $return_html;
  }

  public function save(Request $request)
  {
    $input = $request->all();

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to create this discount. ";
    }
    // Конец проверки прав пользователя

    $discount = new Discount;
    $discount->amount = $input['amount'];
    $discount->user_id = $input['user_id'];
    $discount->save();

    return "Discount addition OK.";
  }

  public function remove($client_id, $discount_id)
  {
    $client = User::find($client_id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($client->wash_id)){
      return "Not allowed to remove this user's discount.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Удалить скидку?',
       'execpath'=>'/discounts/delete/'.$discount_id
    ])->render();
    return $return_html;
  }

  public function delete($id)
  {
    $discount = Discount::where('id','=', $id)->with('user')->first();

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($discount->user->wash_id)){
      return "Not allowed to delete this user's discount.";
    }
    // Конец проверки прав пользователя

    $discount->delete();
  }
}
