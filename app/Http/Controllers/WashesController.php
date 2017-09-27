<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use Validator;
use View;
use DB;
use Carbon;

use App\Wash;
use App\User;
use App\Role;
use App\Box;
use App\Service;
use App\Auto;
use App\AutoService;
use App\Washsession;
use App\Payment;
use App\WashsessionAutoservice;

class WashesController extends Controller
{
  public function __construct()
  {
  $this->middleware('auth');
  }

	public function index()
	{
    $user_washes = Wash::where('owner_id','=', Auth::user()->id)->get();
	  return view('washes.index')->with('washes', $user_washes);
	}

  public function load($id){
    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to get this wash";
    }

    $current_wash = Wash::with(['duty', 'duty.dutytype'])->find($id);

    return $current_wash;
  }

	public function show($id)
  {

    $user = Auth::user();
    if(!$user->owns_or_manages($id)){
      return "Not allowed to view this wash";
    }

	  $wash = Wash::findOrFail($id);
	  $washes = Wash::where('owner_id','=', Auth::user()->id)->get();
	  $roles = Role::subordinate()->get();
	  $workers = User::where('wash_id','=',$id)->get();

	  $auto_services = AutoService::whereHas('auto', function($q) use($id){
		     $q->where('wash_id','=', $id);
		 })->get();
	  return view('washes.show')->with('wash', $wash)->with('washes', $washes)
	  ->with('roles', $roles)->with('workers', $workers)->with('auto_services', $auto_services);
	}

	public function create()
	{
	  return view('washes.create');
	}

	public function store(Request $request)
	{

    $validator = Validator::make($request->all(), [
      'title' => 'required|unique:washes|max:255',
    ]);

    $user = Auth::user();

    $validator->after(function($validator)
    {
      if((!$user->hasRole('Administrator'))&&(!$user->hasRole('Director')))
      {
        return redirect('auth/login');
      }
    });

	  $input = $request->all();
	  $wash = new Wash;
	  $wash->title = $input['title'];
	  $wash->owner_id = $user->id;
	  $wash->save();

	  //return "New wash addition OK.";
	  return redirect('/');
	}

  public function remove($id)
  {
    $wash = Wash::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns($wash->id)){
      return "Not allowed to remove this wash.";
    }
    // Конец проверки прав пользователя

    $return_html = View::make(
      'dialogs/common/ask',
      ['title'=>'Подтверждение',
       'prompt'=>'Удалить эту запись?',
       'execpath'=>'/users/delete/'.$id
    ])->render();
    return $return_html;
  }

  public function delete($id)
  {
    $wash = Wash::find($id);

    // Проверка прав пользователя
    $user = Auth::user();
    if(!$user->owns($wash->id)){
      return "Not allowed to delete this wash.";
    }
    // Конец проверки прав пользователя

    AutoService::with('auto')->whereHas('auto', function($q) use($wash){
         $q->where('wash_id','=', $wash->id);
    })->delete();

    Payment::with('washsession')->whereHas('washsession', function($q) use($wash){
         $q->where('wash_id','=', $wash->id);
    })->delete();

    WashsessionAutoservice::with('washsession')->whereHas('washsession', function($q) use($wash){
         $q->where('wash_id','=', $wash->id);
    })->delete();

    Washsession::where('wash_id', '=',  $wash->id)->delete();
    Box::where('wash_id', '=',  $wash->id)->delete();
    Service::where('wash_id', '=',  $wash->id)->delete();
    Auto::where('wash_id', '=',  $wash->id)->delete();
    User::where('wash_id', '=',  $wash->id)->delete();


    $wash->delete();

    return redirect('/');
  }
}
