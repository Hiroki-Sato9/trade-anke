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
    
    public function create(Request $request)
    {
        return view('surveys.create');
    }
    
    public function store(Request $request, Survey $survey)
    {
        $survey_input = $request['survey'];
        $question_input = $request['question'];
        
        $survey->fill($survey_input);
        $request->user()->surveys()->save($survey);
        // $survey->fill($survey_input)->save();
        
        return redirect('/surveys/' . $survey->id);
    }
}
