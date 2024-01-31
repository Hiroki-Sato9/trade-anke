<?php
namespace App\Services;

use Google_client;
use Google_Service_Forms;

class FormsAPIService
{
    public function __construct($form_url, $redirect_uri)
    {
        if (!empty(session('google_access_token'))) {
            session()->forget('google_access_token');
        }
        // APIクライアントの初期化
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config_path() . '/google_client_secret.json');
        $this->client->setRedirectUri($redirect_uri);
        $this->client->addScope(Google_Service_Forms::FORMS_BODY);
        $this->client->setAccessType('offline');
        
        $this->service = new Google_Service_Forms($this->client);
        $this->id = $this->get_form_id($form_url);
        // リダイレクトURIの設定
        
        if (!$this->is_authenticated()) {
            // 認証URLの生成
            session(['code_verifier' => $this->client->getOAuth2Service()->generateCodeVerifier()]);
            $this->auth_url = $this->client->createAuthUrl();
        }
        
    }
    
    public function is_authenticated() {
        if (!empty(session('google_access_token'))) {
            return true;
        } else {
            return false;
        }
    }
    
    public function get_survey_iframe()
    {
        
    }
    
    // 
    public function get_questions()
    {
        
    }
    
    // { メールアドレス => { question => answer } }
    public function get_answers_by_user()
    {
        
    }
    
    
    
    // アクセストークンをセッションに保存する
    public function set_token($code=null)
    {
        if ($this->is_authenticated()) {
            $token = session('google_access_token');
            $this->client->setAccessToken($token);
            return true;
        }
        
        $token = $this->client->fetchAccessTokenWithAuthCode($code, session('code_verifier'));
        // dd($token);
        $this->client->setAccessToken($token);
        session(['google_access_token' => $token]);
        return true;
    }
    
    // 受け取ったフォームのURLからIDを取得する
    private function get_form_id($url)
    {
        $pre = '|https://docs.google.com/forms/d/e/';
        $suf = '/viewform|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return $data[1];
    }
    
    
}