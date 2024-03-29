<?php
namespace App\Services;

use Google_client;
use Google_Service_Forms;

class FormsAPIService
{
    public $client;
    public $service;
    public $redirect_uri;
    private $form_id;
    
    public function __construct($form_id='', $redirect_uri='')
    {
        $this->redirect_uri = $redirect_uri == '' ? route('forms.connect') : $redirect_uri;
        $this->init($this->redirect_uri);
        $this->form_id = $form_id;
    }
    
    private function init($redirect_uri)
    {
        $this->client = new Google_client();
        $this->client->setAuthConfig(config_path() . '/google_client_secret.json');
        $this->client->setRedirectUri($this->redirect_uri);
        $this->client->addScope([Google_Service_Forms::FORMS_BODY, Google_Service_Forms::FORMS_RESPONSES_READONLY]);
        $this->client->setAccessType('offline');
        $this->service = new Google_Service_Forms($this->client);
    }
    
    // 受け取ったフォームのURLからIDを取得する
    public static function get_form_id($url)
    {
        $pre = '|https://docs.google.com/forms/d(/e)*/';
        $suf = '/.+|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return isset($data[2]) ? $data[2] : $url;
    }
    
    // APiが使用可能か。アクセストークンをセッションに持っているか
    // クライアントに
    public function can_set_token()
    {
        return !empty(session()->get('upload_token'));
    }
    
    // セッションから、アクセストークンを取得しクライアントに渡す
    public function set_access_token()
    {
        if ($this->can_set_token() && !$this->client->getAccessToken()) {
            // dd(session('upload_token'));
            $this->client->setAccessToken(session('upload_token'));
            if ($this->client->isAccessTokenExpired()) {
                session()->forget('upload_token');
            }
        }
    }
    
    // アンケートの質問一覧の取得
    public function get_questions()
    {
        $items = $this->service->forms->get($this->form_id)
            ->getItems();
        
        $questions = [];
        foreach ($items as $item) {
            $question_id = $item->getQuestionItem()->getQuestion()->questionId;
            $questions[$question_id] = $item->title;
        }
        return $questions;
    }
    
    // ユーザーごとの回答を取得する
    public function get_answers_by_user()
    {
        $responses = $this->service->forms_responses->listFormsResponses($this->form_id)
            ->getResponses();
          
        //Answer[]
        $answers = [];
        foreach ($responses as $response) {
            if ($response->respondentEmail) {
                $arr = [];
                // $response->getAnswers(): Answer[]
                // getTextAnswers()->getAnswers: TextAnswer[]
                foreach ($response->getAnswers() as $answer) {
                    $arr[$answer->questionId] = array_map(function ($n){
                        return $n->value;
                    }, $answer->getTextAnswers()->getAnswers());
                    // $answer->getTextAnswers();
                }
                $answers[] = ["email" => $response->respondentEmail, "answers" => $arr];
            }
        }
            // ->getAnswers();
        
        return $answers;
    }
}