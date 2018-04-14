<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\RescuerMessageEvent;
use App\Geolocation;
class RescuerMessages extends Model
{
    protected $fillable = [
      'message', 'messageDate'
    ];

    public function rescuerName()
    {
      return $this->belongsTo(Geolocation::class, 'geolocation_id');
    }
}
