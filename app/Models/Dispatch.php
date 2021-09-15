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

    public function buyerOrder()
    {
        return $this->belongsTo('App\Models\BuyerOrder');
    }
    public function partner()
    {
        return $this->belongsTo('App\Models\Partner');
    }
}
