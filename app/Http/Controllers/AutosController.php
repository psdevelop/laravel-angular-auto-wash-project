<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use View;

use App\Auto;
use App\AutoService;
use App\Box;

class AutosController extends Controller
{
  public function index($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to list these auto types. ";
    }
    // Конец проверки прав пользователя

    $autos = auto::where('wash_id','=',$id)->where('visibility','=',1)->get();
    return $autos;
  }

  public function create($id)
  {
    $return_html = View::make('dialogs/autos/new',['wash_id'=>$id])->render();
    return $return_html;
  }


  public function edit($auto_id)
  {
    $edit_auto = Auto::find($auto_id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($edit_auto->wash_id)){
      return "Not allowed to edit this auto. ";
    }
    // Конец проверки прав пользователя

    $return_html = View::make('dialogs/autos/edit',['auto'=>$edit_auto])->render();
    return $return_html;
  }

  public function update(Request $request)
  {
    $input = $request->all();
    $update_auto = Auto::find($input['auto_id']);
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($update_auto->wash_id)){
      return "Not allowed to update this auto type. ";
    }
    // Конец проверки прав пользователя

    $update_auto->title = $input['title'];
    $update_auto->icon = $input['icon'];
    $update_auto->save();

    return "Auto type addition OK.";
  }

  public function store(Request $request)
  {
    $input = $request->all();

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to edit this auto type. ";
    }
    // Конец проверки прав пользователя

    $new_auto = new Auto;
    $new_auto->title = $input['title'];
    $new_auto->wash_id = $input['wash_id'];
    $new_auto->icon = $input['icon'];
    $new_auto->save();

    return "Auto type addition OK.";
    //return redirect('washes/'.$new_auto->wash_id);
  }

  public function remove($id)
  {
    $auto = Auto::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($auto->wash_id)){
      return "Not allowed to remove this auto.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Удалить эту запись?',
       'execpath'=>'/autos/delete/'.$id
    ])->render();
    return $return_html;
  }

  public function delete($id)
  {
    $auto = Auto::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($auto->wash_id)){
      return "Not allowed to remove this auto.";
    }
    // Конец проверки прав пользователя
    /*
    $messed_boxes = Box::with('washsession')->with('washsession.auto')->whereHas('washsession.auto', function($q) use($id){
         $q->where('id','=', $id);
     })->get();

     foreach ($messed_boxes as $key => $box) {
       if(isset($box) && ($box->washsession_id != 0)){
         $box->washsession_id = 0;
         $box->save();
       }
     }

    AutoService::where('auto_id','=',$auto->id)->delete();
    */

    $auto->visibility = 0;
    $auto->save();
  }



}
