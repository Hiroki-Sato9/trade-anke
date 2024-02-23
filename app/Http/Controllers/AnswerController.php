<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Delivered;

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
    
    public function store(Survey $survey, Request $request)
    {
        $answer_input = $request['answer'];
        if ($survey->is_form_survey() == false) {
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
        }
        // Deliveredモデルの取得・更新
        $delivered = Delivered::where('user_id', $request->user()->id)
            ->where('survey_id', $survey->id)->first();
        $delivered->is_answered = true;
        $delivered->save();
        
        $request->user()->profile->add_point(10);
        return redirect('/profile/');
    }
}
