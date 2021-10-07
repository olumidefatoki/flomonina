<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;
    protected $table = 'delivery';

    public function dispatch()
    {
        return $this->belongsTo('App\Models\Dispatch');
    }

    public function trade()
    {
        return $this->buyerOrder('App\Models\Trade');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
