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
        // dd(session('google_access_token'));
        $form_service = new FormsAPIService('https://docs.google.com/forms/d/e/1FAIpQLSeSDM5wYGvsn7zAmH49F9ghUSVisqE19aBUdibbwyvpDXHAyQ/viewform?usp=sf_link',$request->url());
        
        // dd($form_service);
        if ($request->get('code')) {
            $form_service->set_token($request->get('code'));
            // $form_data = $form_service->service->forms->get($form_service->id);
            // dd($form_data);
             header('Location: ' . filter_var($request->url(), FILTER_SANITIZE_URL));
        }
        
        if ($form_service->client->getAccessToken()) {
            $access_token = $form_service->client->getAccessToken();
            dd($access_token['access_token']);
            // $data = $form_service->service->forms->get($form_service->id);
            // dd($data);
        }
        
        
        return view('static_pages.test')
            ->with(['auth_url' => $form_service->auth_url]);
    }
}
