<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Box extends Model
{
  use SoftDeletes;


  protected $dates = ['deleted_at'];

  public function wash()
	{
	  return $this->belongsTo('App\Wash');
	}

	public function user()
	{
	  // TODO добавить operator'a
    return $this->belongsTo('App\User', 'worker_id');
	}

  public function washsession()
  {
    return $this->belongsTo('App\Washsession', 'washsession_id');
  }

  public function washsessions()
  {
    return $this->hasMany('App\Washsession');
  }
}
