<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TideUpdates extends Model
{
    protected $fillable = [
        'date_gathered', 'tideTime', 'tideHeight_mt', 'tideDateTime', 'tideType'
    ];
}
