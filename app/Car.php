<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
  use SoftDeletes;


  protected $dates = ['deleted_at'];

	public function user()
	{
	  // TODO добавить operator'a
    return $this->belongsTo('App\User', 'user_id');
	}

  public function color()
	{
	  // TODO добавить operator'a
    return $this->belongsTo('App\Color', 'color_id');
	}
  public function autotype()
	{
	  // TODO добавить operator'a
    return $this->belongsTo('App\Auto', 'auto_id');
	}
}
