<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Forms;

class GoogleFormsController extends Controller
{
    //
    public function connect(Request $request)
    {
        // codeパラメータが与えられているなら
        if (false) {
            // クライアントライブラリの初期化
            $client = new Google_Client();
            $client->setAuthConfig(config_path() . '/google_client_secret.json');
            $client->addScope(Google_Service_Forms::FORMS_BODY);
            $client->setAccessType('offline');
            // リダイレクトURIの設定
            $client->setRedirectUri($request->url());
            
            // 認証URLの生成
            $auth_url = $client->createAuthUrl();
            
            // 認証へリダイレクトさせる
            
        } else {
            // 認証コードの取得
            // APIアクセストークンの取得
        }
    }
    
    public function test(Request $request)
    {
        $client = new Google_Client();
        $client->setAuthConfig(config_path() . '/google_client_secret.json');
        $client->setRedirectUri($request->fullUrl());
        $client->addScope(Google_Service_Forms::FORMS_BODY);
        $client->setAccessType('offline');
        
        // 偽造防止のためにトークンを指定
        // $state = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 40);
        
        // GoogleのOAuth2.0サーバーへリクエストを行うためのURLを作成する
        $auth_url = $client->createAuthUrl();
        
        if ($request->get('code')) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
            $client->setAccessToken($token);
        }
        
        return view('static_pages.test')
            ->with(['auth_url' => $auth_url]);
    }
}
