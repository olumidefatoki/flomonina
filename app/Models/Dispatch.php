<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dispatch extends Model
{
    use HasFactory;
    protected $table = 'dispatch';

    public function delivery()
    {
        return $this->hasOne('App\Models\Delivery');
    }

    public function trade()
    {
        return $this->belongsTo('App\Models\Trade');
    }
    public function aggregator()
    {
        return $this->belongsTo('App\Models\aggregator');
    }
}
