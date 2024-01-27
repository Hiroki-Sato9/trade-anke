<?php
namespace App\Services;

use Google_client;
use Google_Service_Forms;

class FormsAPIService
{
    public function __construct($form_url, $redirect_uri)
    {
        // APIクライアントの初期化
        $this->client = new Google_Client();
        $this->client->setAuthConfig(config_path() . '/google_client_secret.json');
        $this->client->addScope(Google_Service_Forms::FORMS_BODY);
        $this->client->setAccessType('offline');
        
        $this->service = new Google_Service_Forms($this->client);
        $this->id = $this->get_form_id($form_url);
        // リダイレクトURIの設定
        $this->client->setRedirectUri($redirect_uri);
        
        if ($this->is_authenticated()) {
            $this->set_token();
        } else {
            // 認証URLの生成
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
    
    // アクセストークンをセッションに保存する
    public function set_token($code=null)
    {
        if ($this->is_authenticated()) {
            $this->token = session('google_access_token');
            $this->client->setAccessToken($code);
            return true;
        }
        
        $this->token = $this->client->fetchAccessTokenWithAuthCode($code);
        $this->client->setAccessToken($code);
        session(['google_access_token' => $this->token]);
        return true;
    }
    
    // 受け取ったフォームのURLからIDを取得する
    public function get_form_id($url)
    {
        $pre = '|https://docs.google.com/forms/d/e/';
        $suf = '/viewform|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return $data[1];
    }
    
    public function get_survey_iframe()
    {
        
    }
    
    
}