<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\CitizenReports;

class IPAddress extends Model
{
    protected $fillable = [
        'ip', 'dateStart', 'dateFinished', 'count'
    ];

    // public function user() {
    //     $this->belongsTo('App\CitizenReports');
    // }
}
