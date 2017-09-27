<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use View;
use DB;

use App\Service;
use App\AutoService;

class ServicesController extends Controller
{
  public function index($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to list these services. ";
    }
    // Конец проверки прав пользователя

    $services = Service::where('wash_id','=',$id)->get();
    return $services;
  }

  public function show($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view new service dialog. ";
    }
    // Конец проверки прав пользователя

    $return_html = View::make('dialogs/services/new',['wash_id'=>$id])->render();
    return $return_html;
  }

  public function save(Request $request)
  {
    $input = $request->all();

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to edit this service. ";
    }
    // Конец проверки прав пользователя

    $new_service = new Service;
    $new_service->title = $input['title'];
    $new_service->wash_id = $input['wash_id'];
    $new_service->save();

    return "Sevice addition OK.";
    // return redirect('washes/'.$new_service->wash_id);
  }

  public function remove($id)
  {
    $service = Service::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($service->wash_id)){
      return "Not allowed to remove this service.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Удалить эту запись?',
       'execpath'=>'/services/delete/'.$id
    ])->render();
    return $return_html;
  }

  public function delete($id)
  {
    $service = Service::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($service->wash_id)){
      return "Not allowed to delete this service.";
    }
    // Конец проверки прав пользователя
    DB::transaction(function()use($service){
      AutoService::where('service_id','=',$service->id)->delete();
      $service->delete();
    });

  }
}
