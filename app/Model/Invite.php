<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'invite';
    protected $fillable = ['code','data','type'];
}
