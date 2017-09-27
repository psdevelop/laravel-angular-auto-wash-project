<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AutoService extends Model
{
    use SoftDeletes;

    protected $table = 'autotype_services';
  	protected $fillable = ['cost'];

    protected $dates = ['deleted_at'];


  	public function service()
  	{
  	  return $this->belongsTo('App\Service');
  	}

  	public function auto()
  	{
  	  return $this->belongsTo('App\Auto');
  	}

}
