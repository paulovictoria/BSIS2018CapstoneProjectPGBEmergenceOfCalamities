<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CitizenReports;
use App\Events\RescuerLocationEvent;
use App\RescuerNotifications;
use App\RescuerMessages;
class Geolocation extends Model
{
    protected $fillable = [
     'rescuerName', 'password', 'lat', 'lng', 'municipality', 'assignRoute', 
    ];

    protected $hidden = [
      
    ];

    protected $dispatchesEvents = [
        'updating' => RescuerLocationEvent::class,
    ];

    public function notifications()
    {
      return $this->hasMany(RescuerNotifications::class);
    }

    public function rescuerMessages()
    {
       return $this->hasMany(RescuerMessages::class);
    }
}
