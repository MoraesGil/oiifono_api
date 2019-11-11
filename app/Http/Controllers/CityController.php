<?php

namespace App\Http\Controllers;

use App\Entities\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function typeahead($query = ''){
        return City::where('name', 'like', $query.'%')->limit(15)->get();
    }
}
