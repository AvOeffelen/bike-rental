<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BicycleRepair extends Model
{
    protected $table = 'bicycle_repair';

    protected $fillable = ['bicycle_id','description','granted','is_finished','finished_at'];


    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'finished_at' => 'datetime:d-m-Y',
    ];


    public function Bicycle()
    {
        return $this->belongsTo(Bicycle::class);
    }
}
