<?php

namespace App\Http\Controllers;

use App\Models\Lga;
use Illuminate\Http\Request;



class ResourceController extends Controller
{
    //

    public function getLgaByStateId($id)
    {
       
        $lga = Lga::where('state_id', $id)->get();
        return json_encode($lga);
    }
}
