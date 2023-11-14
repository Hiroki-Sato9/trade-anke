<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Survey;
use App\Models\Question;
use App\Http\Requests\SurveyRequest;

use Illuminate\Support\Facades\DB;

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
        return view('surveys.create')->with(['genders' => DB::table('genders')->get()]);
    }
    
    public function store(Survey $survey, SurveyRequest $request)
    {
        $survey_input = $request['survey'];
        $question_input = $request['question'];
        // dd($question_input);
        
        $survey->fill($survey_input);
        $request->user()->surveys()->save($survey);
        
        $question_models = [];
        foreach ($question_input as $question){
            array_push($question_models, new Question($question));
        }
    
        $survey->questions()->saveMany($question_models);
        $survey->refresh();
        
        return redirect('/surveys/' . $survey->id);
    }
}
