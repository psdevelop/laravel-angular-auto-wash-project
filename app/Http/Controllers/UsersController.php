<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use View;
use App\User;
use App\Role;
use App\Paymenttype;

class UsersController extends Controller
{
  public function add()
  {
    $sub_roles = Role::subordinate()->get();
    return view('users.create')->with('roles',$sub_roles);
  }

  public function createClient($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to create new client here. ";
    }
    // Конец проверки прав пользователя

    $payment_types = Paymenttype::all();
    $return_html = View::make('dialogs/clients/new',['wash_id'=>$id, 'payment_types'=>$payment_types])->render();
    return $return_html;
  }

  public function saveClient(Request $request)
  {
    $input = $request->all();
    $new_user = new User;
    $new_user->name = $input['name'];
    $new_user->email = $input['email'];
    $new_user->phone = $input['phone'];
    $new_user->role_id = Role::client()->id;
    $new_user->wash_id = $input['wash_id'];
    $new_user->paymenttype_id = $input['payment_type'];
    $new_user->save();

    return "New client addition OK.";
  }

  public function show($user_id)
  {
    $employee = User::with('role')->find($user_id);
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($employee->wash_id)){
      return "Not allowed to edit this user. ";
    }
    // Конец проверки прав пользователя
    $sub_roles = Role::subordinate()->get();

    $return_html = View::make('dialogs/users/update',['employee'=>$employee, 'roles'=>$sub_roles])->render();

    return $return_html;
  }

  public function showClient($user_id)
  {
    $employee = User::with('role')->find($user_id);
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($employee->wash_id)){
      return "Not allowed to edit this user. ";
    }
    // Конец проверки прав пользователя
    $payment_types = Paymenttype::all();
    $return_html = View::make('dialogs/clients/update',['employee'=>$employee, 'payment_types'=>$payment_types])->render();

    return $return_html;
  }

  public function update(Request $request)
  {
    $input = $request->all();
    $edit_user = User::with('role')->find($input['user_id']);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($edit_user->wash_id)){
      return "Not allowed to update this user's profile. ";
    }
    // Конец проверки прав пользователя

    $edit_user = User::find($input['user_id']);
    $edit_user->name = $input['name'];
    $edit_user->email = $input['email'];
    $edit_user->phone = $input['phone'];
    $edit_user->role_id = $input['role_id'];
    if($input['new_password'] !== '') $edit_user->password = bcrypt($input['new_password']);
    $edit_user->save();

    return "User update OK.";
  }

  public function updateClient(Request $request)
  {
    $input = $request->all();
    $edit_user = User::with('role')->find($input['user_id']);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($edit_user->wash_id)){
      return "Not allowed to update this user's profile. ";
    }
    // Конец проверки прав пользователя

    $edit_user = User::find($input['user_id']);
    $edit_user->name = $input['name'];
    $edit_user->email = $input['email'];
    $edit_user->phone = $input['phone'];
    $edit_user->paymenttype_id = $input['payment_type'];
    if($input['new_password'] !== '') $edit_user->password = bcrypt($input['new_password']);
    $edit_user->save();

    return "Client update OK.";
  }

  public function find($key, $wash_id){
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($wash_id)){
      return [];
    }
    // Конец проверки прав пользователя
    $found_users = User::where('wash_id','=', $wash_id)
    ->where('role_id','=', Role::client()->id)
    ->with('cars')->with('cars.color')->with('cars.autotype')->with('cars.user.discounts')
    ->where(function($query)use($key){
      $query->where('phone', 'LIKE', "%$key%")->orWhere('name', 'LIKE', "%$key%");
    })->get();
    return $found_users;
  }

  public function getWorkers($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to get the workers list.";
    }
    // Конец проверки прав пользователя

    $workers = User::where('wash_id','=',$id)->where('visibility','=',1)->with('role')->whereIn('role_id',array(Role::operator()->id , Role::manager()->id))->get();
    return $workers;

    //return Wash::first()->employees($id);
  }

  public function getClients($id)
  {
    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to get the workers list.";
    }
    // Конец проверки прав пользователя

    $clients = User::where('visibility','=',1)->with('role')->with('paymenttype')->with('cars')->with('cars.color')
    ->with('discounts')->where('wash_id','=',$id)->where('role_id','=', Role::client()->id)->get();
    return $clients;

    //return Wash::first()->employees($id);
  }

  public function saveUser(Request $request)
	{
	  $input = $request->all();
	  $new_user = new User;
	  $new_user->name = $input['name'];
	  $new_user->email = $input['email'];
	  $new_user->phone = $input['phone'];
	  $new_user->role_id = $input['role_id'];
	  $new_user->wash_id = $input['wash_id'];
	  $new_user->password = bcrypt($input['password']);
	  $new_user->save();

	  return "New employee addition OK.";

	  //return redirect('washes/'.$new_user->wash_id);
	}

  public function remove($id)
  {
    $employee = User::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($employee->wash_id)){
      return "Not allowed to remove this user.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Удалить этого пользователя?',
       'execpath'=>'/users/delete/'.$id
    ])->render();
    return $return_html;
  }

  public function delete($id)
  {
    $employee = User::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns_or_manages($employee->wash_id)){
      return "Not allowed to delete this user.";
    }
    // Конец проверки прав пользователя

    //AutoService::where('service_id','=',$service->id)->delete();
    //$employee->delete();

    $employee->visibility = 0;
    $employee->save();
  }
}
