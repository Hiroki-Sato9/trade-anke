<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Forms;

use App\Services\FormsAPIService;
use App\Models\User;
use App\Models\Survey;
use App\Models\Question;
use App\Models\Answer;

class GoogleFormsController extends Controller
{
    // アクセストークンを取得し、セッションに保存する役割を担う。
    // トークンをクライアントにセットするのはそれぞれのアクション内で行われる
    public function connect(Request $request)
    {
        
        $form_service = new FormsAPIService();
        
        if (!empty($request->get('code'))) {
            $token = $form_service->client->fetchAccessTokenWithAuthCode($request->get('code'), session('code_verifier'));
            session(['upload_token' => $token]);
            // header('Location: ' . filter_var($form_service->redirect_uri, FILTER_SANITIZE_URL));
        } 
        
        if ($form_service->can_set_token()) {
            $url = session('redirect_url');
            session()->forget('redirect_url');
            // 元のアクションへリダイレクト
            return redirect($url);
        } else {
            session()->put('redirect_url', url()->previous());
            session()->put('code_verifier', $form_service->client->getOAuth2Service()->generateCodeVerifier());
            $auth_url = $form_service->client->createAuthUrl();

            return redirect($auth_url);
        }
        // return view('static_pages.test')
        //     ->with(['auth_url' => isset($auth_url) ? $auth_url : null]);
    }
    
    public function update(Survey $survey, Request $request)
    {
        $form_service = new FormsAPIService($survey->form_id);
        // アクセストークンを保持しているか
        if (!$form_service->can_set_token()) {
            // connectアクションへリダイレクト
            return redirect()->route('forms.connect');
        }
        // アクセストークンをセットして、アンケート結果の取得処理
        // $form_service->set_access_token();
        $form_service->client->setAccessToken(session('upload_token'));
        if ($form_service->client->isAccessTokenExpired()) {
            session()->forget('upload_token');
        } else {
            
        }
        
        // 質問の保存処理
        $questions = $form_service->get_questions();
        $question_models = [];
        foreach ($questions as $key => $value) {
            $question_models[$key] = new Question(['body' => $value]);
        }
        // dd(array_values($question_models));
        $survey->questions()->saveMany(array_values($question_models));
        
        // 回答の保存処理
        $answers_by_user = $form_service->get_answers_by_user();
        foreach ($answers_by_user as $answer_data) {
            if (!User::where('email', $answer_data['email'])->exists()) {
                continue;
            }
            // クエリが無駄に発生している？
            $user = User::where('email', $answer_data['email'])->first();
            foreach ($answer_data['answers'] as $question_form_id => $body) {
                $question = $question_models[$question_form_id]->fresh();
                $answer = new Answer([
                    'user_id' => $user->id,
                    'body' => $body[0],
                ]);
                $question->answers()->save($answer);
            }
        }
        return redirect()->route('surveys.show', ['survey' => $survey->id]);
    }
    
    public function test(Request $request)
    {
        // session()->forget('upload_token');
        $form_service = new FormsAPIService('1bHVxZjWPrQKUwdwB6aa_849DPlSKXdiIaj9SlABpe_0', $request->url());
        
        if (!empty($request->get('code'))) {
            $token = $form_service->client->fetchAccessTokenWithAuthCode($request->get('code'), session('code_verifier'));
            $form_service->client->setAccessToken($token);
            header('Location: ' . filter_var($form_service->redirect_uri, FILTER_SANITIZE_URL));
        }
        
        if ($form_service->can_set_token()) {
            $form_service->client->setAccessToken(session('upload_token'));
            if ($form_service->client->isAccessTokenExpired()) {
                session()->forget('upload_token');
            }
        } else {
            session()->put('code_verifier', $form_service->client->getOAuth2Service()->generateCodeVerifier());
            $auth_url = $form_service->client->createAuthUrl();
        }
        
        if ($form_service->client->getAccessToken()) {
            // dd($client->getAccessToken());
            $data = $form_service->get_answers_by_user();
            // $data = $form_service->get_questions();
            dd($data);
        }

        
        return view('static_pages.test')
            ->with(['auth_url' => isset($auth_url) ? $auth_url : null]);
    }
}

        // $form_service = new FormsAPIService('https://docs.google.com/forms/d/e/1FAIpQLSeSDM5wYGvsn7zAmH49F9ghUSVisqE19aBUdibbwyvpDXHAyQ/viewform?usp=sf_link',$request->url());