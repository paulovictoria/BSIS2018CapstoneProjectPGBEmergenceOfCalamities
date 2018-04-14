<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Geolocation;
use App\Events\NotifyInSiteEvent;

class RescuerNotifications extends Model
{
  protected $fillable = [
    'location', 'time', 'landmark', 'citizen_name', 'type', 'status', 'image'
  ];
  
  public function rescuer() {
    return $this->belongsTo(Geolocation::class, 'geolocation_id');
  }
}
