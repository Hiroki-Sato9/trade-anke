<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Forms;

use App\Services\FormsAPIService;

class GoogleFormsController extends Controller
{
    //
    public function connect(Request $request)
    {
        // codeパラメータが与えられているなら
        if (empty($request->get('code'))) {
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
            return redirect($auth_url);
            
        } else {
            // 認証コードの取得
            // APIアクセストークンの取得
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'));
            $request->session()->put('google.access', $token);
        }
    }
    
    public function test(Request $request)
    {
        $redirect_uri = $request->url();
        
        $client = new Google_Client();
        $client->setAuthConfig(config_path() . '/google_client_secret.json');
        $client->setRedirectUri($redirect_uri);
        $client->addScope(Google_Service_Forms::FORMS_BODY);
        $client->setAccessType('offline');
        $service = new Google_Service_Forms($client);
        
        if (!empty($request->get('code'))) {
            $token = $client->fetchAccessTokenWithAuthCode($request->get('code'), session('code_verifier'));
            $client->setAccessToken($token);
            header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
        }
        
        if (!empty(session('upload_token'))) {
            $client->setAccessToken(session('upload_token'));
            if ($client->isAccessTokenExpired()) {
                session()->forget('upload_token');
            }
        } else {
            session()->put('code_verifier', $client->getOAuth2Service()->generateCodeVerifier());
            $auth_url = $client->createAuthUrl();
        }
        
        if ($client->getAccessToken()) {
            // dd($client->getAccessToken());
            $data = $service->forms->get('1-fLk6OQWXuQswmxohkYs9U3W304SF81IDg4rOWMBWPk');
            dd($data);
        }

        
        return view('static_pages.test')
            ->with(['auth_url' => isset($auth_url) ? $auth_url : null]);
    }
}

        // $form_service = new FormsAPIService('https://docs.google.com/forms/d/e/1FAIpQLSeSDM5wYGvsn7zAmH49F9ghUSVisqE19aBUdibbwyvpDXHAyQ/viewform?usp=sf_link',$request->url());