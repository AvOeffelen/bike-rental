<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Bicycle extends Model
{
    protected $table = 'bicycle';

    protected $fillable = ['framenumber','available','in_repair'];
    protected $dates = ['created_at','updated_at'];

    public function BicycleHistory()
    {
        return $this->hasMany(BicycleHistory::class)->orderBy('created_at','DESC');
    }

    public function BicycleRepair(){
        return $this->hasMany(BicycleRepair::class);
    }
}
