<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Admin;

class DamUpdates extends Model
{
    protected $fillable = ['amount'];
    public function user() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
