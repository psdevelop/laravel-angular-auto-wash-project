<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
  use SoftDeletes;


  protected $dates = ['deleted_at'];

  public function formatCurrency($in)
  {
    $result = floatval($in);

    if(floor($result) == $result){
      return $result;
    } else {
      return sprintf('%0.2f', round($result, 2));
    }


  }

  public function washsession()
  {
    return $this->belongsTo('App\Washsession', 'washsession_id');
  }
}
