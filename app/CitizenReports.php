<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Events\SendReportEvent;
use App\IPAddress;
class CitizenReports extends Model
{
    protected $fillable = [
        'fullName', 
        'address', 
        'municipality', 
        'contactNumber', 
        'landline',
        'landmark', 
        'type', 
        'reportedDate', 
        'lat', 
        'lng', 
        'rescuedTime', 
        'status', 
        'respondTime', 
        'ip',
        'image'
    ];

    public function scopeUndone($query, $status) {
        return $query->where('status', '=', $status);
    }
    
    public function scopeAddress($query, $address)
    {
        return $query->where('address', 'LIKE', '%'.$address.'%');
    }
    
    public function scopeExactAddress($query, $address)
    {
        return $query->where('address', '=', $address);
    }
    
    public function scopeDate($query, $date) {
        return $query->whereDate('reportedDate', '=',  date($date));
    }

    public function scopeDesc($query)
    {
        return $query->orderBy('reportedDate', 'desc');
    }
    public function scopeType($query, $type)
    {
        return $query->where('type', '=', $type);
    }

    public function scopeLandmark($query, $landmark)
    {
        return $query->where('landmark', '=', $landmark);
    }

    public function scopeMunicipality($query, $municipality)
    {
       return $query->where('municipality', '=', $municipality);
    }

    public function scopeTodaysTotalReports($query, $date)
    {
      return $query->whereDate('reportedDate', '=',  date($date))->count();
    }

    public function scopeDateRange($query, $date)
    {
      return $query->whereDate('reportedDate', '>=',  date($date));
    }
    
    protected $dispatchesEvents = [
        'saved' => SendReportEvent::class
    ];
}
