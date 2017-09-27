<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use Carbon;

use App\Service;
use App\Auto;
use App\AutoService;
use App\Payment;
use App\Color;
use App\Role;
use App\User;
use App\Box;
use App\Duty;
use App\Wash;
use App\Washsession;

class ReportsController extends Controller
{
  public function showBoxesParameters($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed see these boxes parameters. ";
    }
    // Конец проверки прав пользователя

    $boxes = Box::where('wash_id','=', $id)->get();
    $return_html = View::make('fragments/_boxes_report_form',['boxes'=>$boxes, 'wash_id'=>$id])->render();
    return $return_html;
  }

  public function showBoxesReport(Request $request) {
    $input = $request->all();

    $id = $input['wash_id'];
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to see this boxes report. ";
    }
    // Конец проверки прав пользователя

    $current_wash = Wash::find($id);

    $boxes_array = $input['box_id'];
    $period_start = $input['period_start'];
    $period_end = $input['period_end'];

    $boxes = Box::with(['washsessions'=>function($q)use($period_start, $period_end){
      $q->where('created_at', '>=', Carbon\Carbon::parse($period_start, 'Europe/Moscow')->setTimezone('UTC'))
        ->where('created_at', '<=', Carbon\Carbon::parse($period_end, 'Europe/Moscow')->addDay()->setTimezone('UTC'))
      ->with(['duty', 'duty.dutytype', 'payment', 'user', 'car', 'car.user', 'discount']);
    }])->where('wash_id','=', $id)->whereIn('id', $boxes_array)->get();

    $total_profit = 0;
    foreach($boxes as $box){
      $box->total_income = 0;
      foreach($box->washsessions as $washsession){
          $box->total_income += $washsession->payment->total_cost;
      }

      $box->total_salary = $box->total_income * ($washsession->duty->dutytype->salary_perc*0.01);
      $box->total_profit = $box->total_income /* * (1.0 - ($washsession->duty->dutytype->salary_perc*0.01)) */;
      $total_profit += $box->total_profit;
    }

    $payment = Payment::first();
    $return_html = View::make('fragments/_boxes_report',['boxes'=>$boxes, 'total_profit'=>$total_profit, 'payment'=>$payment])->render();
    return $return_html;
  }

  public function showClientsParameters($id) {

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed see these clients parameters. ";
    }
    // Конец проверки прав пользователя

    $clients = User::where('wash_id','=', $id)->where('role_id','=', Role::client()->id)->get();
    $return_html = View::make('fragments/_clients_report_form',['clients'=>$clients, 'wash_id'=>$id])->render();
    return $return_html;
  }

  public function showClientsReport(Request $request) {
    $input = $request->all();
    $id = $input['wash_id'];

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to see this clients report. ";
    }
    // Конец проверки прав пользователя

    $client_id = $input['client_choice'];
    $period_start = $input['period_start'];
    $period_end = $input['period_end'];

    $client = User::find($client_id);

    $washsessions = Washsession::with(['car.user'=>function($q)use($client_id){
      $q->where('id','=', $client_id);
    }])->where('wash_id','=', $id)->where('visibility','=', 1)
    ->whereBetween('created_at',[Carbon\Carbon::parse($period_start, 'Europe/Moscow')->setTimezone('UTC'),
    Carbon\Carbon::parse($period_end, 'Europe/Moscow')->addDay()->setTimezone('UTC')])
    ->with(['user','box','payment', 'washservices', 'washservices.autoservice.service', 'discount'])->get();

    $payment = Payment::first();
    $return_html = View::make('fragments/_clients_report',['client'=>$client, 'washsessions'=>$washsessions, 'payment'=>$payment])->render();
    return $return_html;
  }

  public function showNoncashParameters($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed see these clients parameters. ";
    }
    // Конец проверки прав пользователя

    $clients = User::where('wash_id','=', $id)->where('role_id','=', Role::client()->id)->where('paymenttype_id','=','2')->get();
    $return_html = View::make('fragments/_clients_report_form',['clients'=>$clients, 'wash_id'=>$id])->render();
    return $return_html;
  }

  public function showDutiesParameters($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed see these duties parameters. ";
    }
    // Конец проверки прав пользователя

    $duties = Duty::whereHas('dutytype',function($q)use($id){
      $q->where('wash_id','=', $id);
    })->orderBy('created_at', 'desc')->get();

    for($i = 0; $i < count($duties); ++$i){
      $duties[$i]->created_at = $duties[$i]->created_at->setTimezone("Europe/Moscow");
    }

    $return_html = View::make('fragments/_duties_report_form',['duties'=>$duties, 'wash_id'=>$id])->render();
    return $return_html;
  }

  public function showDutiesReport(Request $request){
    $input = $request->all();
    $id = $input['wash_id'];

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to see this clients report. ";
    }
    // Конец проверки прав пользователя

    $duty_id = $input['duty_choice'];
    $duty = Duty::with('dutytype')->find($duty_id);
    $duty->created_at = $duty->created_at->setTimezone("Europe/Moscow");

    $washsessions = Washsession::where('duty_id','=',$duty_id)->where('visibility','=', 1)->with('car')->with('car.autotype')->with('box')->with('washservices')
    ->with('car.user')->with('payment')->with('discount')->with('washservices.autoservice.service')->orderBy('started_at','desc')->get();

    for($i = 0; $i < count($washsessions); ++$i){
      $washsessions[$i]->created_at = $washsessions[$i]->created_at->setTimezone("Europe/Moscow");
    }

    $payment = Payment::first();
    $return_html = View::make('fragments/_duties_report',['duty'=>$duty, 'washsessions'=>$washsessions, 'payment'=>$payment])->render();
    return $return_html;
  }

  public function showBoxStatisticsParameters($id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed see these duties parameters. ";
    }
    // Конец проверки прав пользователя

    $duties = Duty::whereHas('dutytype',function($q)use($id){
      $q->where('wash_id','=', $id);
    })->orderBy('created_at', 'desc')->get();

    for($i = 0; $i < count($duties); ++$i){
      $duties[$i]->created_at = $duties[$i]->created_at->setTimezone("Europe/Moscow");
    }

    $boxes = Box::where('wash_id','=', $id)->get();

    $return_html = View::make('fragments/_boxstat_report_form',['duties'=>$duties, 'boxes'=>$boxes, 'wash_id'=>$id])->render();
    return $return_html;
  }

  public function showBoxStatisticsReport(Request $request) {
    $input = $request->all();
    $id = $input['wash_id'];

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to see this clients report. ";
    }
    // Конец проверки прав пользователя

    $duty_id = $input['duty_choice'];
    $boxes_array = $input['box_id'];
    $duty = Duty::with('dutytype')->find($duty_id);
    $duty->created_at = $duty->created_at->setTimezone("Europe/Moscow");

    $washsessions = Washsession::where('duty_id','=',$duty_id)->where('visibility','=', 1)->with('car')->with('car.autotype')->with('box')->with('washservices')
    ->with('car.user')->with('payment')->with('discount')->with('washservices.autoservice.service')->whereIn('box_id', $boxes_array)->orderBy('started_at','desc')->get();

    for($i = 0; $i < count($washsessions); ++$i){
      $washsessions[$i]->created_at = $washsessions[$i]->created_at->setTimezone("Europe/Moscow");
    }

    $payment = Payment::first();
    $return_html = View::make('fragments/_boxstat_report',['duty'=>$duty, 'washsessions'=>$washsessions, 'payment'=>$payment])->render();
    return $return_html;
  }


}
