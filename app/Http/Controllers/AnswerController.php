<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;

class AnswerController extends Controller
{
    //
    public function create(Survey $survey)
    {
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
        }
        return redirect('/profile/');
    }
}
