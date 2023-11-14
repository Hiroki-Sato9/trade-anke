<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Answer;
use App\Models\Survey;

class AnswerController extends Controller
{
    //
    public function create(Survey $survey)
    {
        return view('answers.answer')->with(['survey' => $survey]);
    }
    
    public function store(Request $request, Answer $answer)
    {
        // dd($request->survey);
        // surveyモデルの獲得
        $survey = Survey::find($request->survey_id);
        
        $input = $request['answer'];
        // dd($input);
        $answer_models = [];
        foreach($input as $answer){
            array_push($answer_models, new Answer($answer));
        }
        // dd($answer_models);
        
        $survey->answers()->saveMany($answer_models);
        $answer->refresh();
        return redirect('/profile/');
    }
}
