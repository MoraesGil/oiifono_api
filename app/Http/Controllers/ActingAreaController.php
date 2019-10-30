<?php

namespace App\Http\Controllers;
use Traits\Controllers\ApiRestfulTrait;
use Illuminate\Http\Request;
class ActingAreaController extends Controller
{
    use ApiRestfulTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        dd('oi mundo');
    }

    public function index(Request $request)
    {
        return $this->getData($request);
    }
    //
}
