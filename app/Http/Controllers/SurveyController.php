<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Survey;

class SurveyController extends Controller
{
    //
    public function index(Survey $survey)
    {
        // dd($survey->get());
        return view('surveys.index')
            ->with(['surveys' => $survey->get()]);
    }
    
    public function show(Survey $survey)
    {
        return view('surveys.show')
            ->with(['survey' => $survey]);
    }
}
