<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
// use Symfony\Component\HttpFoundation\StreamedResponse;

use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;
use App\Http\Requests\SurveyRequest;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use App\Services\FormsAPIService;

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
        $surveys = Survey::search($params)->paginate(15);
        
        return view('surveys.index')
            ->with(['surveys' => $surveys,
                    'genders' => $this->genders,
                    'vals' => $request->query()]);
    }
    
    public function show(Survey $survey, Request $request)
    {
        if ($survey->is_form_survey()) {
            $form_service = new FormsAPIService('1-fLk6OQWXuQswmxohkYs9U3W304SF81IDg4rOWMBWPk');
            // アクセストークンを保持しているか
            if ($form_service->can_set_token()) {
                // アクセストークンをセットして、アンケート結果の取得処理
                // $form_service->set_access_token();
                $form_service->client->setAccessToken(session('upload_token'));
                if ($form_service->client->isAccessTokenExpired()) {
                    session()->forget('upload_token');
                }
                $data = $form_service->get_questions();
                dd($data);
            } else {
                // connectアクションへリダイレクト
                return redirect()->route('forms.connect');
            }
        } else {
            
        }
        
        // アクセスしたユーザーがこのアンケートの作成者ならば、回答一覧を表示する
        $answers_by_user = [];
        if ($request->user() && $request->user()->is($survey->user)){
            $answers_by_user = Answer::answers_by_user($survey);
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

        // Google Formsを利用する場合とそれ以外の処理
        if ($survey_input['form_url']) {
            $url = $survey_input['form_url'];
            $survey->form_id = FormsAPIService::get_form_id($url);
            $survey->save();
        } else {
            $question_models = [];
            foreach ($question_input as $question){
                array_push($question_models, new Question($question));
            }
            $survey->questions()->saveMany($question_models);
        }
        
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
    
    // ユーザがアンケートを受け取る
    public function take(Request $request)
    {
        $result = Survey::deliver_to_user($request->user());
        
        if ($result) {
            return Redirect::route('profile.detail')->with('flash_message', "アンケートを付与しました");
        } else {
            return Redirect::route('profile.detail')->with('flash_message', "あなたが回答できるアンケートがありません");
        }
    }
    
    public function export(Request $request)
    {
        $survey = Survey::find($request->query('survey'));
        $questions = $survey->questions->map(function ($item) { return $item->body; });
        $answers_by_user = Answer::answers_by_user($survey);
        // dd($answers);
        
        $callback = function () use ($questions, $answers_by_user) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, $questions->toArray());
            
            foreach ($answers_by_user as $key => $answers) {
                $arr = $answers->map(function ($item) { return $item->body; });
                // dd($arr);
                fputcsv($handle, $arr->toArray());
            }
            fclose($handle);
        };
        return response()->streamDownload($callback, 'sample.csv');
    }
}
