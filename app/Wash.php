<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;

class Wash extends Model
{
  use SoftDeletes;


  protected $dates = ['deleted_at'];

  public function boxes()
	{
	  return $this->hasMany('App\Box');
	}

  public function duty()
	{
	  return $this->belongsTo('App\Duty');
	}

  // Abandoned! Implemented directly in UsersController/getWorkers
  /*
  public function employees($id) {
    $subordinates = User::with('role')->where('wash_id','=',$id)->get();
    return $subordinates;
  }
  */
}
