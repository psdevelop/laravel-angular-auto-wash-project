<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon;

use Auth;
use View;

use App\Box;
use App\Service;
use App\Auto;
use App\User;
use App\Role;
use App\Car;
use App\AutoService;
use App\Customservice;
use App\Washsession;
use App\Wash;
use App\WashsessionAutoservice;
use App\Discount;
use App\Payment;

class WashsessionsController extends Controller
{
  public function index($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to edit these washsessions. ";
    }
    // Конец проверки прав пользователя

    $services = Service::where('wash_id','=',$id)->get();
    $boxes = Box::where('wash_id','=',$id)->get();
    $autos = Auto::where('wash_id','=',$id)->get();
    // $get_time = Carbon\Carbon::now('Europe/Moscow');

    $auto_services = AutoService::with('service')->with('auto')->whereHas('auto', function($q) use($id){
         $q->where('wash_id','=', $id);
     })->orderBy('created_at', 'desc')->get();

     $washsessions = Washsession::where('wash_id','=',$id)->orderBy('started_at', 'desc')->with('car')->with('car.autotype')->with('box')->with('washservices')
     ->with('car.user')->with('payment')->with('discount')->with('washservices.autoservice.service')->get();
     $current_washsessions = array();
     foreach ($washsessions as $key => $washsession) {
       $washsession->complete = $washsession->getComplete($washsession->id);
       $washsession->started_at = $washsession->started_at->setTimezone("Europe/Moscow");
       $washsession->finished_at = $washsession->finished_at->setTimezone("Europe/Moscow");

       $current_washsessions[$washsession->id] = $washsession;
     }

    return response()->json(['boxes'=>$boxes, 'services'=>$services, 'autos'=>$autos, 'auto_services'=>$auto_services, 'washsessions'=>$current_washsessions ]);
  }

  public function detail($id){
    $washsession = Washsession::find($id);

    $user = Auth::user();
    if(!$user->owns_or_manages($washsession->wash_id)){
      return "Not allowed to detail this washsession. ";
    }

    $washsession = Washsession::with(['payment', 'washservices', 'washservices.autoservice.service', 'customservices'])->find($id);
    $payment = Payment::first();

    $return_html = View::make('dialogs/washsessions/detail', ['payment'=>$payment, 'washsession'=>$washsession,
    'washservices'=>$washsession->washservices, 'customservices'=>$washsession->customservices])->render();
    return $return_html;
  }

  public function listWashsessions($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to edit these washsessions. ";
    }
    // Конец проверки прав пользователя

    $wash = Wash::find($id);
    $washsessions = Washsession::where('wash_id','=',$id)->where('visibility','=',1)->where('duty_id','=',$wash->duty_id)->orderBy('started_at', 'desc')
    ->with('car')->with('car.autotype')->with('box')->with('washservices')
    ->with('car.user')->with('payment')->with('discount')->with('washservices.autoservice.service')->get();

    return $washsessions;
  }

   public function complete($id){
     Washsession::getComplete($id);
   }

   public function refresh($id){
     // Проверка прав пользователя
     $user = Auth::user();
     if(!$user->owns_or_manages($id)){
       return "Not allowed to refresh these washsessions. ";
     }
     // Конец проверки прав пользователя

     $current_washsessions = array();
     $boxes = Box::where('wash_id','=',$id)->get();
     foreach($boxes as $box){
       if($box->washsession_id != 0){
          $washsession = Washsession::with('car')->with('car.autotype')->with('car.color')->with('payment')
                         ->with('car.user')->with('discount')->with('box')->orderBy('created_at', 'desc')
                         ->find($box->washsession_id);
          $washsession->complete = $washsession->getComplete($box->washsession_id);
          $washsession->started_at = $washsession->started_at->setTimezone("Europe/Moscow");
          $washsession->finished_at = $washsession->finished_at->setTimezone("Europe/Moscow");
          $current_washsessions[$box->washsession_id] = $washsession;

       }
     }

     return response()->json(['washsessions'=>$current_washsessions]);
   }

   public function store(Request $request)
   {
     $input = $request->all();

     // Проверка прав пользователя
     $user = Auth::user();
     if((!$user->owns_or_manages($input['wash_id']))&&(!$user->operates($input['box_id']))){
       return "Not allowed to edit this washsession. ";
     }
     // Конец проверки прав пользователя

     $result = "";

     if($input['order_switch'] == 1){
       $result = $this->slowCreate($request);
     } else {
       $result = $this->fastCreate($request);
     }

     return $result;
   }

   public function slowCreate(Request $request)
   {
     $input = $request->all();

     // Проверка прав пользователя
     $user = Auth::user();
     if((!$user->owns_or_manages($input['wash_id']))&&(!$user->operates($input['box_id']))){
       return "Not allowed to edit this washsession. ";
     }
     // Конец проверки прав пользователя

     $new_washsession = new Washsession;
     $new_washsession->wash_id = $input['wash_id'];
     $new_washsession->box_id = $input['box_id'];
     $new_washsession->car_id = $input['car_id'];
     $new_washsession->duty_id = $input['duty_id'];
     $currentBox = Box::find($input['box_id']);
     $new_washsession->user_id = $currentBox->worker_id;
     $new_washsession->local_discount = $input['washsession_discount'];
     $new_washsession->total_summ = $input['total_cost'];
     //$new_washsession->started_at = Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$input['start_date']." ".$input['start_time']);
     $new_washsession->started_at = Carbon\Carbon::parse($input['start_date']." ".$input['start_time'], 'Europe/Moscow')->setTimezone('UTC');
     $new_washsession->finished_at = Carbon\Carbon::parse($input['start_date']." ".$input['start_time'], 'Europe/Moscow')->addMinutes($input['total_timing'])->setTimezone('UTC');
     $new_washsession->save();

     foreach($input['autoservice_id'] as $key => $value){
       $new_washsession_autoservice = new WashsessionAutoservice;
       $new_washsession_autoservice->washsession_id = $new_washsession->id;
       $new_washsession_autoservice->autoservice_id = $value;
       $new_washsession_autoservice->cost = $input['autoservice_cost'][$key];
       $new_washsession_autoservice->save();
     }

     if(isset($input['custom_service_count']) && $input['custom_service_count'] > 0){
        $custom_service_count = $input['custom_service_count'];
        for($k=0; $k<$custom_service_count; $k++){
          $new_custom_service = new Customservice;
          $new_custom_service->title = $input['custom_service_title'][$k];
          $new_custom_service->cost = $input['custom_service_cost'][$k];
          $new_custom_service->timing = $input['custom_service_time'][$k];
          $new_custom_service->washsession_id = $new_washsession->id;
          $new_custom_service->save();
        }
     }

     if(isset($input['discount']) && $input['discount'] > 0){
       $new_discount = new Discount;
       $new_discount->washsession_id = $new_washsession->id;
       $new_discount->amount = $input['discount'];
       $new_discount->save();
     }

     $box = Box::find($new_washsession->box_id);
     $box->washsession_id = $new_washsession->id;
     $box->save();

     $new_payment = new Payment;
     $new_payment->washsession_id = $new_washsession->id;
     $new_payment->total_cost = $input['total_cost'];
     $new_payment->save();

     return "Washsession addition OK.";
   }

   public function fastCreate(Request $request)
   {
     $input = $request->all();

     // Проверка прав пользователя
     $user = Auth::user();
     if((!$user->owns_or_manages($input['wash_id']))&&(!$user->operates($input['box_id']))){
       return "Not allowed to edit this washsession. ";
     }
     // Конец проверки прав пользователя

     $new_user = new User;
     $new_user->name = $input['new_client_name'];
     $new_user->email = $input['new_client_email'];
     $new_user->phone = $input['new_client_phone'];
     $new_user->role_id = Role::client()->id;
     $new_user->wash_id = $input['wash_id'];
     $new_user->save();


     $new_car = new Car;
     $new_car->title = $input['title'];
     $new_car->user_id = $new_user->id;
     $new_car->color_id = $input['color_id'];
     $new_car->number = $input['number'];
     $new_car->auto_id = $input['autotype_id'];
     $new_car->save();

     $new_washsession = new Washsession;
     $new_washsession->wash_id = $input['wash_id'];
     $new_washsession->box_id = $input['box_id'];
     $new_washsession->car_id = $new_car->id;
     $new_washsession->duty_id = $input['duty_id'];
     $currentBox = Box::find($input['box_id']);
     $new_washsession->user_id = $currentBox->worker_id;
     $new_washsession->local_discount = $input['washsession_discount'];
     $new_washsession->total_summ = $input['total_cost'];
     //$new_washsession->started_at = Carbon\Carbon::createFromFormat('Y-m-d H:m:s',$input['start_date']." ".$input['start_time']);
     $new_washsession->started_at = Carbon\Carbon::parse($input['start_date']." ".$input['start_time'], 'Europe/Moscow')->setTimezone('UTC');
     $new_washsession->finished_at = Carbon\Carbon::parse($input['start_date']." ".$input['start_time'], 'Europe/Moscow')->addMinutes($input['total_timing'])->setTimezone('UTC');
     $new_washsession->save();

     foreach($input['autoservice_id'] as $key => $value){
       $new_washsession_autoservice = new WashsessionAutoservice;
       $new_washsession_autoservice->washsession_id = $new_washsession->id;
       $new_washsession_autoservice->autoservice_id = $value;
       $new_washsession_autoservice->cost = $input['autoservice_cost'][$key];
       $new_washsession_autoservice->save();
     }

     if(isset($input['custom_service_count']) && $input['custom_service_count'] > 0){
        $custom_service_count = $input['custom_service_count'];
        for($k=0; $k<$custom_service_count; $k++){
          $new_custom_service = new Customservice;
          $new_custom_service->title = $input['custom_service_title'][$k];
          $new_custom_service->cost = $input['custom_service_cost'][$k];
          $new_custom_service->timing = $input['custom_service_time'][$k];
          $new_custom_service->washsession_id = $new_washsession->id;
          $new_custom_service->save();
        }
     }

     $box = Box::find($new_washsession->box_id);
     $box->washsession_id = $new_washsession->id;
     $box->save();

     $new_payment = new Payment;
     $new_payment->washsession_id = $new_washsession->id;
     $new_payment->total_cost = $input['total_cost'];
     $new_payment->save();

     return "Fast washsession creation OK.";

   }

   public function remove($id)
   {
     $washsession = Washsession::find($id);

     // Проверка прав пользователя
     $user = Auth::user();
     if(!$user->owns_or_manages($washsession->wash_id)){
       return "Not allowed to remove this washsession.";
     }
     // Конец проверки прав пользователя

     $return_html = View::make(
       'dialogs/common/ask',
       ['title'=>'Подтверждение',
        'prompt'=>'Удалить этот сеанс?',
        'execpath'=>'/washsessions/delete/'.$id
     ])->render();
     return $return_html;
   }

   public function delete($id)
   {
     $washsession = Washsession::with('box')->find($id);

     // Проверка прав пользователя
     $user = Auth::user();
     if(!$user->owns_or_manages($washsession->wash_id)){
       return "Not allowed to delete this washsession.";
     }
     // Конец проверки прав пользователя

     if(isset($washsession->box)){
       $box = Box::find($washsession->box->id);
       $box->washsession_id = 0;
       $box->save();
     }

     $washsession->visibility = 0;
     $washsession->save();
   }
}
