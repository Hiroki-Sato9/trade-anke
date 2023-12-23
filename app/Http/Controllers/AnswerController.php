<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;

class AnswerController extends Controller
{
    //
    public function create(Survey $survey)
    {
        if (! Gate::allows('answer-survey', $survey)) {
            abort(403);
        }
        
        return view('answers.answer')->with(['survey' => $survey]);
    }
    
    public function store(Request $request)
    {
        $answer_input = $request['answer'];
        
        foreach($answer_input as $input){
            $question = Question::find($input['question_id']);
            $answer = new Answer(
                ['user_id' => $input['user_id'],
                 'body' => $input['body'],
            ]);
            $question->answers()->save($answer);
            $question->survey->answer_num += 1;
            $question->survey->save();
        }
        $request->user()->profile->add_point(10);
        return redirect('/profile/');
    }
}
