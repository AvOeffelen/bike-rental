<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BicycleHistory extends Model
{
    protected $table = 'bicycle_history';

    protected $fillable = ['bicycle_id','title','description'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
    ];

    public function Bicycle()
    {
        return $this->belongsTo(Bicycle::class);
    }

}
