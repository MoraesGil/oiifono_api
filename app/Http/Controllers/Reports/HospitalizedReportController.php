<?php

namespace App\Http\Controllers\Reports;

use App\Entities\Individual;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;

class HospitalizedReportController extends Controller
{
    public function index(Request $request)
    {
        $patients = Individual::query()
            ->whereHas('hospitalizations', function (Builder $query) {
                $query->where('discharged', null);
            })->with('person', 'hospitalizations', 'hospitalizations.healthPlan')
            ->get();

        return view('reports.hospitalized', compact('patients'));
    }
}
