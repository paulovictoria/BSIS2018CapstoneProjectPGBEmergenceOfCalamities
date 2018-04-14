<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeamLeaders extends Model
{
    protected $fillable = [
        'full_name', 'contact_number', 'address', 'municipality'
    ];  
}
