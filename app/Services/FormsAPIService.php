<?php
namespace App\Services;

use Google_client;
use Google_Service_Forms;

class FormsAPIService
{
    public function __construct($redirect_uri, $form_url)
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
        // 認証URLの生成
        $this->auth_url = $this->client->createAuthUrl();
    }
    
    // アクセストークンをセッションに保存する
    public function store_token($code)
    {
        $this->token = $this->client->fetchAccessTokenWithAuthCode($code);
        session('access_token', $this->token);
    }
    
    // 受け取ったフォームのURLからIDを取得する
    public function get_form_id($url)
    {
        $pre = '|https://docs.google.com/forms/d/e/';
        $suf = '/viewform|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return $data[1];
    }
}