<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NumberUtils extends Model
{
    use HasFactory;
    function isValidDecimalNumber($value){
        if (strpos($value,".")) {
            if (preg_match("/^[0-9]{1,9}\.[0-9]{1,5}?$/", $value)) {
                  return true;
            }
          }
          else {
           if(preg_match("/^[0-9]{1,9}?$/", $value))
             return true;
          }
    }
}
