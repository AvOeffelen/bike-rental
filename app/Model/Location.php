<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $table = 'location';

    protected $fillable = ['name','address','managed_by','number','postalcode'];


    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Bicycle()
    {
        return $this->hasMany(Bicycle::class);
    }
}
