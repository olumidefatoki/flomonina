<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buyer extends Model
{
    use HasFactory;
    protected $table = 'buyer';

    public function state()
    {
        return $this->belongsTo('App\State');
        
    }

    public function buyerOrder()
    {
        return $this->hasMany('App\Models\BuyerOrder');
    }

}
