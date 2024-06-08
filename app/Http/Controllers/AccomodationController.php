<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccomodationController extends Controller
{
   public function getAllAcommodations(Request $request){
     return response()->json([
        'message' => 'All accomodation'
     ]);
   }
}
