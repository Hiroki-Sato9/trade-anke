<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Survey;
use App\Models\Question;
use App\Http\Requests\SurveyRequest;

use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    // public $genders;
    
    public function __construct()
    {
        $this->genders =  DB::table('genders')->get();
    }
    
    public function index(Request $request)
    {
        $params = $request->query();
        $surveys = Survey::search($params)->get();
        
        return view('surveys.index')
            ->with(['surveys' => $surveys,
                    'genders' => $this->genders]);
    }
    
    public function show(Survey $survey)
    {
        return view('surveys.show')
            ->with(['survey' => $survey,
                    'gender' => DB::table('genders')->find($survey->gender_id)]);
    }
    
    public function create(Request $request)
    {
        return view('surveys.create')->with(['genders' => $this->genders]);
    }
    
    public function store(Survey $survey, SurveyRequest $request)
    {
        $survey_input = $request['survey'];
        $question_input = $request['question'];
        
        $survey->fill($survey_input);
        $request->user()->surveys()->save($survey);
        
        $question_models = [];
        foreach ($question_input as $question){
            array_push($question_models, new Question($question));
        }
        $survey->questions()->saveMany($question_models);
        
        $request->user()->profile->add_point(-1);
    
        return redirect('/surveys/' . $survey->id);
    }
}
