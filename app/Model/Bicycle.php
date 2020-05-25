<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bicycle extends Model
{
    protected $table = 'bicycle';

    protected $fillable = ['framenumber','available','in_repair','location_id','lease_start','lease_end'];
    protected $dates = ['created_at','updated_at','lease_start','lease_end'];
    protected $casts = [
        'lease_start' => 'datetime:d-m-Y',
        'lease_end' => 'datetime:d-m-Y',
    ];

    public function BicycleHistory()
    {
        return $this->hasMany(BicycleHistory::class)->orderBy('created_at','DESC');
    }

    public function BicycleRepair(){
        return $this->hasMany(BicycleRepair::class);
    }

    public function Location()
    {
        return $this->belongsTo(Location::class);
    }
}
