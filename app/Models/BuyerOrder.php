<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyerOrder extends Model
{
    use HasFactory;
    protected $table = 'buyer_order';

    public function buyer()
    {
        return $this->belongsTo('App\Models\Buyer');
    }

    public function state()
    {
        return $this->belongsTo('App\Models\State');
    }

    public function commodity()
    {
        return $this->belongsTo('App\Models\Commodity');
    }
    
    public function delivery()
    {
        return $this->hasOne('App\Models\Delivery');
    }

    public function dispatch()
    {
        return $this->hasMany('App\Models\Dispatch');
    }
}
