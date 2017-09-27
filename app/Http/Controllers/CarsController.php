<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use Auth;

use App\Auto;
use App\Color;
use App\Car;

class CarsController extends Controller
{
  public function find($key, $wash_id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($wash_id)){
      return [];
    }
    // Конец проверки прав пользователя

    $found_cars = Car::where('number', 'LIKE', "%$key%")->with('color')->with('autotype')->with('user')->with('user.discounts')->whereHas('user', function($q) use($wash_id){
         $q->where('wash_id','=', $wash_id);
     })->get();
    return $found_cars;
  }

  public function create($id, $client_id) {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to create car for this client. ";
    }
    // Конец проверки прав пользователя
    $colors = color::all();
    $auto_types = auto::where('wash_id','=',$id)->get();
    $return_html = View::make('dialogs/cars/new',['wash_id'=>$id, 'client_id'=>$client_id, 'auto_types'=>$auto_types, 'colors'=>$colors])->render();
    return $return_html;
  }

  public function save(Request $request)
  {
    $input = $request->all();
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($input['wash_id'])){
      return "Not allowed to add this car. ";
    }
    // Конец проверки прав пользователя

    $new_car = new Car;
    $new_car->title = $input['title'];
    $new_car->user_id = $input['user_id'];
    $new_car->color_id = $input['color_id'];
    $new_car->number = $input['number'];
    $new_car->auto_id = $input['auto_id'];
    $new_car->save();

    return "Car addition OK.";
    // return redirect('washes/'.$new_service->wash_id);
  }
}
