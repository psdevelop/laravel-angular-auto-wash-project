<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use App\Wash;
use App\Auto;
use App\Color;
use App\Dutytype;
use App\Duty;
use App\Box;

class DutiesController extends Controller
{

  public function create($id) {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to create new duty for this wash. ";
    }
    // Конец проверки прав пользователя

    $return_html = View::make('dialogs/duties/new',['wash_id'=>$id])->render();
    return $return_html;
  }

  public function save(Request $request)
  {
    $input = $request->all();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to add this duty. ";
    }
    // Конец проверки прав пользователя

    $new_dutytype = new Dutytype;
    $new_dutytype->title = $input['title'];
    $new_dutytype->wash_id = $input['wash_id'];
    $new_dutytype->salary_perc = $input['salary_perc'];
    $new_dutytype->save();

    return "Dutytype addition OK.";
  }

  public function open($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to open duty for this wash. ";
    }
    // Конец проверки прав пользователя

    $dutytypes = Dutytype::where('wash_id','=', $id)->get();

    $return_html = View::make('dialogs/duties/open', ['wash_id'=>$id, 'dutytypes'=>$dutytypes])->render();
    return $return_html;
  }

  public function close($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to close this duty.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Закрыть текущую смену?',
       'execpath'=>'/duties/unregister/'.$id
    ])->render();
    return $return_html;
  }

  public function register(Request $request)
  {
    $input = $request->all();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to add this duty. ";
    }
    // Конец проверки прав пользователя

    $register_duty = new Duty;
    $register_duty->dutytype_id = $input['dutytype_id'];
    $register_duty->save();

    $current_wash = Wash::find($input['wash_id']);
    $current_wash->duty_id = $register_duty->id;
    $current_wash->save();

    return "Dutytype addition OK.";
  }

  public function unregister($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to close this duty. ";
    }
    // Конец проверки прав пользователя

    $current_wash = Wash::find($id);
    $current_wash->duty_id = 0;
    $current_wash->save();

    return "Dutytype addition OK.";
  }

  public function currentSalary($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these boxes. ";
    }

    // Конец проверки прав пользователя
    $current_duty_id = Wash::find($id)->duty_id;
    if($current_duty_id == 0){
      return [];
    }

    $duty = Duty::with('dutytype')->find($current_duty_id);

    $boxes = Box::where('wash_id','=',$id)->whereHas('washsessions', function($q)use($current_duty_id){
      $q->where('duty_id','=',$current_duty_id)->where('visibility','=',1)->with('payment');
    })->get();

    //$boxes = Box::where('wash_id','=',$id)->with(['washsessions', 'washsessions.payment'])->get();

    $salaries = array();
    $total_summs = array();
    for($i = 0; $i < count($boxes); ++$i){
      $salaries[$i] = 0;
      $total_summs[$i] = 0;
      for($j = 0; $j < count($boxes[$i]->washsessions); ++$j ){
        if(($boxes[$i]->washsessions[$j]->duty_id == $current_duty_id)&&($boxes[$i]->washsessions[$j]->visibility == 1)){
          $salaries[$i] += $boxes[$i]->washsessions[$j]->payment->total_cost * 0.01 * $duty->dutytype->salary_perc;
          $total_summs[$i] += $boxes[$i]->washsessions[$j]->payment->total_cost;
        }
      }
    }

    $return_html = View::make('dialogs/duties/salary', ['boxes'=>$boxes, 'salaries'=>$salaries, 'total_summs'=>$total_summs, 'duty'=>$duty])->render();
    return $return_html;
  }
}
