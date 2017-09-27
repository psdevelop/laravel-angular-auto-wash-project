<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Wash;
use App\Box;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'role_id', 'password'];
    protected $dates = ['deleted_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

	public function role()
	{
	  return $this->belongsTo('App\Role');
	}
  public function paymenttype()
	{
	  return $this->belongsTo('App\Paymenttype');
	}

  public function cars()
	{
	  return $this->hasMany('App\Car');
	}

  public function discounts()
	{
	  return $this->hasMany('App\Discount');
	}

	 /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
	public function hasRole($role_title)
	{
	  return ( $this->role->title == $role_title );
	}


  // Domain specific methods
  public function owns($id) // Check if user owns the wash
  {
    $check_wash = Wash::find($id);
    if(isset($check_wash)){
      if($check_wash->owner_id == $this->id){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function manages($id) // Check if user manages the wash
  {
    $check_wash = Wash::find($id);
    if(isset($check_wash)){
      if(($check_wash->id == $this->wash_id)&&($this->hasRole('Manager'))){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function owns_or_manages($id)
  {
    return ($this->owns($id) || ($this->manages($id)));
  }

  public function operates($id) // Check if user is operator of the box
  {
    $check_box = Box::find($id);
    if(isset($check_box)){
      if($check_box->worker_id == $this->id){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
}
