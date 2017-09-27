<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
  public function user()
  {
    // TODO добавить operator'a
    return $this->belongsTo('App\User', 'user_id');
  }
}
