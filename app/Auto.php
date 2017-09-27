<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auto extends Model
{

  use SoftDeletes;


  protected $dates = ['deleted_at'];

  public function wash()
  {
    return $this->belongsTo('App\Wash', 'wash_id');
  }
}
