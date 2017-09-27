<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon;

class Washsession extends Model
{
    use SoftDeletes;


    protected $table = 'washsessions';
    protected $dates = ['created_at', 'updated_at', 'started_at', 'finished_at', 'deleted_at'];

    public function washservices()
    {
      return $this->hasMany('App\WashsessionAutoservice');
    }

    public function customservices()
    {
      return $this->hasMany('App\Customservice');
    }

    public function box()
    {
      return $this->belongsTo('App\Box');
    }

    public function auto()
    {
      return $this->belongsTo('App\Car', 'car_id');
    }

    public function car()
    {
      return $this->belongsTo('App\Car', 'car_id');
    }
    public function user()
    {
      return $this->belongsTo('App\User', 'user_id');
    }

    public function wash()
    {
      return $this->belongsTo('App\Wash');
    }

    public function duty()
    {
      return $this->belongsTo('App\Duty');
    }

    public function payment()
    {
      return $this->hasOne('App\Payment');
    }

    public function discount()
    {
      return $this->hasOne('App\Discount');
    }

    public function getComplete($id)
    {
      $washsession = Washsession::findOrFail($id);
      $start_time = Carbon\Carbon::parse($washsession->started_at);
      $end_time =  Carbon\Carbon::parse($washsession->finished_at);
      $now_time = Carbon\Carbon::now();

      //return $start_time->diffInMinutes($end_time, false);
      $total = $start_time->diffInSeconds($end_time, false);
      $finished = $start_time->diffInSeconds($now_time, false);
      $last = $now_time->diffInSeconds($end_time, false);

      if($finished >= $total) return 100;

      $percentage = $total / 100.0;
      $percent = $finished / $percentage;

      return (integer)$percent;
    }

    /*
    public function getStartedAtAttribute($value)
    {
      return  Carbon\Carbon::parse($value)->setTimezone("Europe/Moscow")->toDateTimeString();
    }

    public function getFinishedAtAttribute($value)
    {
      return  Carbon\Carbon::parse($value)->setTimezone("Europe/Moscow")->toDateTimeString();
      //return  Carbon\Carbon::now()->diffInMinutes( Carbon\Carbon::parse($value), false);
    }
    */
}
