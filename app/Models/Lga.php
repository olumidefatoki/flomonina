<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lga extends Model
{
    use HasFactory;
    protected $table = 'lga';

    public function warehouse()
    {
        return $this->hasMany('App\Models\Warehouse');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

}
