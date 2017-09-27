<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];

  	public function user()
  	{
  	  // TODO добавить operator'a
      return $this->belongsTo('App\User', 'user_id');
  	}

    public function washsession()
    {
      return $this->belongsTo('App\User', 'washsession_id');
    }
}
