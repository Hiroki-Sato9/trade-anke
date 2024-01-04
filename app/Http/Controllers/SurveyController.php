<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
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
    
    public function show(Survey $survey, Request $request)
    {
        // アクセスしたユーザーがこのアンケートの作成者ならば、回答一覧を表示する
        $answers_by_user = [];
        if ($request->user() && $request->user()->is($survey->user)){
            $answered_users = $survey->answered_users();
            foreach ($answered_users as $user){
                $answers_by_user[$user->id] = Answer::get_answers($user, $survey);
            }
        }
        
        return view('surveys.show')
            ->with(['survey' => $survey,
                    'gender' => DB::table('genders')->find($survey->gender_id),
                    'answers_by_user' => $answers_by_user,
                   ]);
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
    
    public function deliver(Request $request)
    {
        // 何人に配布するか
        $num = $request->input('num');
        $survey = Survey::find($request->input('survey'));
        
        // ポイントが条件を満たしているか
        if ($request->user()->profile->point > $num) {
            $i = $survey->deliver_survey($num);
            $request->user()->profile->add_point(-$i);
            return Redirect::route('profile.detail')->with('flash_message', "{$i}人にアンケートを配布しました");
        } else {
            return Redirect::route('profile.detail')->with('flash_message', "ポイントが足りません");
        }
    }
}
