<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\Box;
use App\Washsession;
use App\AutoService;
use App\Auto;

use Carbon;

use Auth;
use View;

class BoxesController extends Controller
{
  public function free($box_id)
  {
    $box = Box::find($box_id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($box->wash->id) && !$user->operates($box->id)){
      return "Not allowed to use free box operation.";
    }
    // Конец проверки прав пользователя

    if(isset($box) && ($box->washsession_id != 0)){
      $box->washsession_id = 0;
      $box->save();
    }
  }

  public function manage($id){
    $box = Box::where('worker_id','=',$id)->with('user')->with('wash')->first();
    if(isset($box)){
      // Проверка прав пользователя
      $user = Auth::user();
      if(!$user->operates($box->id)){
        return "Not allowed to manage this box.";
      }
      // Конец проверки прав пользователя

      return view('boxes.manage')->with('box', $box);
    } else {
      return view('boxes.manage');
    }

  }

  public function loadSingle($id){
    $box = Box::with('user')->find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->operates($box->id)){
      return "Not allowed to manage this box.";
    }
    // Конец проверки прав пользователя

    $autos = Auto::where('wash_id','=',$box->wash->id)->get();
    $box->autos = $autos;
    $auto_services = AutoService::with('service')->with('auto')->whereHas('auto', function($q) use($box){
         $q->where('wash_id','=', $box->wash->id);
     })->get();
    $box->auto_services = $auto_services;
    if($box->washsession != null){
      $box->washsession->complete = $box->washsession->getComplete($box->washsession->id);
    }
    return $box;
  }

  public function refreshSingle($id){
    $box = Box::with('user')->with('washsession')->with('washsession.auto')->find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->operates($box->id)){
      return "Not allowed to manage this box.";
    }
    // Конец проверки прав пользователя

    $washsession = $box->washsession;
    if($washsession){
      $washsession->complete = $washsession->getComplete($washsession->id);
      return $washsession;
    }

    return null;
  }

  public function index($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these boxes. ";
    }
    // Конец проверки прав пользователя

    $boxes = Box::with('user')->with('washsession')->with('washsession.payment')->with('washsession.auto')->where('wash_id','=',$id)->get();

    return $boxes;
  }

  public function occupied($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these boxes. ";
    }
    // Конец проверки прав пользователя

    $boxes = Box::where('wash_id','=',$id)->get();
    return $boxes;
  }

  public function records($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these boxes. ";
    }
    // Конец проверки прав пользователя

    $boxes = Box::with('user')->with(['washsessions','washsessions.payment', 'washsessions.user',
    'washsessions.car', 'washsessions.car.user', 'washsessions.discount'])->where('wash_id','=',$id)->get();
    /*foreach ($boxes as $key => $box) {
      if($box->washsession != null){
        $box->washsession->complete = $box->washsession->getComplete($box->washsession->id);
      }
    }*/
    return $boxes;
  }

  public function find($id, $period_start, $period_end) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view these boxes. ";
    }
    // Конец проверки прав пользователя

    $boxes = Box::with(['washsessions'=>function($q)use($period_start, $period_end){
      $q->whereBetween('created_at',[Carbon\Carbon::parse($period_start, 'Europe/Moscow')->setTimezone('UTC'),
      Carbon\Carbon::parse($period_end, 'Europe/Moscow')->addDay()->setTimezone('UTC')])->with(['payment', 'user',
      'car', 'car.user', 'discount']);
    }])->get();
    /*foreach ($boxes as $key => $box) {
      if($box->washsession != null){
        $box->washsession->complete = $box->washsession->getComplete($box->washsession->id);
      }
    }*/
    return $boxes;
  }

  public function create($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to create box here. ";
    }
    // Конец проверки прав пользователя

    //$workers = User::where('wash_id','=',$id)->where('role_id','=',4)->get();
      $workers = User::where('wash_id','=',$id)->where('role_id','=',4)->get();
      $free_workers = array();
      foreach ($workers as $key => $worker) {
        if(!Box::where('worker_id','=',$worker->id)->exists()){
          $free_workers[] = $worker;
        }
      }


    $return_html = View::make('dialogs/boxes/new',['wash_id'=>$id, 'workers'=>$free_workers])->render();
    return $return_html;
  }

  public function edit($id){
    $box = Box::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($box->wash->id)){
      return "Not allowed to edit this box.";
    }

    //$workers = User::where('wash_id','=',$box->wash->id)->where('role_id','=',4)->get();
    $workers = User::where('wash_id','=',$box->wash->id)->where('role_id','=',4)->get();
    $free_workers = array();
    foreach ($workers as $key => $worker) {
      if(!Box::where('worker_id','=',$worker->id)->exists()){
        $free_workers[] = $worker;
      } else if($worker->id == $box->worker_id){
        $free_workers[] = $worker;
      }
    }

    $return_html = View::make('dialogs/boxes/edit',['wash_id'=>$box->wash->id, 'box'=>$box, 'workers'=>$free_workers])->render();
    return $return_html;
  }

  public function update(Request $request)
  {
    $input = $request->all();

    $box = Box::find($input['box_id']);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($box->wash->id)){
      return "Not allowed to update this box.";
    }

    $box->title = $input['title'];
    $box->worker_id = $input['worker_id'];
    $box->wash_id = $input['wash_id'];
    $box->save();

    // return $this->index($input['wash_id']);
    return "Box update SUCCESS.";
  }

  public function save(Request $request)
  {
    $input = $request->all();

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to create box here. ";
    }
    // Конец проверки прав пользователя

    $new_box = new Box;
    $new_box->title = $input['title'];
    $new_box->worker_id = $input['worker_id'];
    $new_box->wash_id = $input['wash_id'];
    $new_box->save();

    // return $this->index($input['wash_id']);
    return "New box creation SUCCESS.";
  }
}
