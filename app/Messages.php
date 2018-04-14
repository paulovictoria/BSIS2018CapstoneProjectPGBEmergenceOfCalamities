<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Admin;
class Messages extends Model
{
    protected $fillable = ['message', 'messageDate'];

    public function user() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
