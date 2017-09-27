<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;


    protected $dates = ['deleted_at'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

	public function users()
	{
	  return $this->hasMany('App\User');
	}

	public function scopeSubordinate($query)
	{
	  return $query->where('title', '!=', 'Administrator' )->where('title', '!=', 'Director' )->where('title', '!=', 'Client' );
	}

	public function scopeDirector($query)
	{
	  return $query->where('title', '=', 'Director' );
	}

	public function scopeOperator($query)
	{
	  return $query->where('title', '=', 'Operator')->first();
	}
  public function scopeManager($query)
  {
    return $query->where('title', '=', 'Manager')->first();
  }
  public function scopeClient($query)
	{
	  return $query->where('title', '=', 'Client')->first();
	}
}
