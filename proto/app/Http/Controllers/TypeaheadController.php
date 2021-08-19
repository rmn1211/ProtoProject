<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Spielplan;

class TypeaheadController extends Controller
{
    public function index()
    {
        return view('check_report');
    }
 
    public function autocompleteSearch(Request $request)
    {
          $query = $request->get('query');
          $filterResult = DB::table(DB::raw('liga'))
          ->where(DB::raw('name', 'LIKE', '%'. $query. '%'))
          ->get();
          
          
          return response()->json($filterResult);
    } 
}





