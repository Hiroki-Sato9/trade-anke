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
    
    public function __construct($form_url, $redirect_uri)
    {
        $this->init($redirect_uri);
        $this->redirect_uri = $redirect_uri;
        $this->form_id = $this->get_form_id($form_url);
    }
    
    private function init($redirect_uri)
    {
        $this->client = new Google_client();
        $this->client->setAuthConfig(config_path() . '/google_client_secret.json');
        $this->client->setRedirectUri($redirect_uri);
        $this->client->addScope([Google_Service_Forms::FORMS_BODY, Google_Service_Forms::FORMS_RESPONSES_READONLY]);
        $this->client->setAccessType('offline');
        $this->service = new Google_Service_Forms($this->client);
    }
    
    // 受け取ったフォームのURLからIDを取得する
    private function get_form_id($url)
    {
        $pre = '|https://docs.google.com/forms/d(/e)*/';
        $suf = '/.+|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return isset($data[2]) ? $data[2] : $url;
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
        // Answer[]
        $responses = $this->service->forms_responses->listFormsResponses($this->form_id)
            ->getResponses();
            
            // ->getAnswers();
        
        return $answers;
    }
}