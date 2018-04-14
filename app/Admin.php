<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\ResetPassword as ResetPasswordNotification;
use App\DamUpdates;
use App\Messages;
use Illuminate\Notifications\Notifiable;
class Admin extends Model implements \Illuminate\Contracts\Auth\Authenticatable, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword, Notifiable;
    protected $fillable = [
        'name', 
        'password', 
        'municipality', 
        'usercontact', 
        'email', 
        'is_verified', 
        'municipalAddress', 
        'userDate',
        'isBlock'
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    public function messages()
    {
        return $this->hasMany(Messages::class);
    }
    public function updates()
    {
        return $this->hasMany(DamUpdates::class);
    }
    public function sendPasswordResetNotification($token)
    {
      $this->notify(new ResetPasswordNotification($token));
    }

    public function scopeActivated($query)
    {
      return $query->where('isBlock','=', null);
    }

    public function scopeBlock($query)
    {
      return $query->where('isBlock','=', 1);
    }

    public function scopeExcept($query, $user)
    {
      return $query->where('municipality','!=', $user);
    }
}
