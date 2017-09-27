<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
  public function user()
  {
    return $this->belongsTo('App\User', 'user_id');
  }

  public function payment()
  {
    return $this->belongsTo('App\Payment', 'payment_id');
  }
}
