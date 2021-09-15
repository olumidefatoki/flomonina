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

    public function buyerOrder()
    {
        return $this->buyerOrder('App\Models\BuyerOrder');
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status');
    }
}
