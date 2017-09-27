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

class PricesController extends Controller
{
  public function index($id)
  {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view this pricelist. ";
    }
    // Конец проверки прав пользователя

    $auto_services = AutoService::with('auto')->with('service')->whereHas('auto', function($q) use($id){
         $q->where('wash_id','=', $id);
     })->orderBy('service_id', 'asc')->get();
    return $auto_services;
  }

  public function load($service_id, $auto_type)
  {
    $auto = Auto::where('id','=',$auto_type)->firstOrFail();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($auto->wash_id)){
      return "Not allowed to view this pricelist. ";
    }
    // Проверка прав пользователя
    $service = Service::where('id','=',$service_id)->firstOrFail();
    if(!$user->owns_or_manages($service->wash_id)){
      return "Not allowed to view this pricelist. ";
    }
    // Конец проверки прав пользователя

    $auto_service = AutoService::where('auto_id','=',$auto_type)->where('service_id','=',$service_id)->first();
    if(isset($auto_service)){
      $return_html = View::make('dialogs/auto_prices/update',['auto_service'=>$auto_service,
    'service'=>$service, 'auto_type'=>$auto])->render();
    }else{
      $return_html = View::make('dialogs/auto_prices/new',['service'=>$service, 'auto_type'=>$auto])->render();
    };

    return $return_html;
  }

  public function store(Request $request)
  {
    $input = $request->all();

    $auto = Auto::where('id', '=', $input['auto_type'])->firstOrFail();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($auto->wash_id)){
      return "Not allowed to add this price. ";
    }
    // Проверка прав пользователя
    $service = Service::where('id', '=', $input['service_id'])->firstOrFail();
    if(!$user->owns_or_manages($service->wash_id)){
      return "Not allowed to add that price. ";
    }
    // Конец проверки прав пользователя

    $new_price = new AutoService;
    $new_price->auto_id = $input['auto_type'];
    $new_price->service_id = $input['service_id'];
    $new_price->cost = $input['cost'];
    $new_price->timing = $input['timing'];

    $new_price->save();

    return "Price addition OK.";
  }

  public function update(Request $request)
  {
    $input = $request->all();

    $auto = Auto::where('id', '=', $input['auto_type'])->firstOrFail();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($auto->wash_id)){
      return "Not allowed to add this price. ";
    }
    // Проверка прав пользователя
    $service = Service::where('id', '=', $input['service_id'])->firstOrFail();
    if(!$user->owns_or_manages($service->wash_id)){
      return "Not allowed to add that price. ";
    }
    // Конец проверки прав пользователя


    $new_price = AutoService::where('auto_id','=',$input['auto_type'])
    ->where('service_id','=',$input['service_id'])->update(['cost'=>$input['cost'], 'timing'=>$input['timing']]);

    return "Price addition OK.";
    //return redirect('washes/'.$new_user->wash_id);
  }
}
