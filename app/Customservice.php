<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Customservice extends Model
{
  protected $table = 'custom_services';

  public function washsession()
	{
	  return $this->belongsTo('App\Washsession', 'washsession_id');
	}
}
