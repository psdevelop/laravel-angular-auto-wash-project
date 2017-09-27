<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

class Duty extends Model
{
  protected $table = 'duties';

  public function dutytype()
	{
	  return $this->belongsTo('App\Dutytype', 'dutytype_id');
	}
}
