<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WashsessionAutoservice extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    protected $table = 'washsession_autoservices';
    protected $fillable = ['washsession_id', 'autoservice_id'];

    public function washsession()
    {
      return $this->belongsTo('App\Washsession');
    }

    public function autoservice()
    {
      return $this->belongsTo('App\AutoService');
    }
}
