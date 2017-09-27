<?php namespace App\Http\Controllers;
use Auth;
use Colors;

class PagesController extends Controller {
  public function lobby()
  {
    if(!Auth::check()){
      return redirect('/auth/login');
    }
    $current_user = Auth::user();

    if($current_user->hasRole('Director')){
      return redirect('/washes/index');
    } else if($current_user->hasRole('Manager')){
      return redirect('/washes'.'/'.$current_user->wash_id);
    } else if($current_user->hasRole('Operator')){

      return redirect('/boxes/manage'.'/'.$current_user->id);
    }
  }
}
