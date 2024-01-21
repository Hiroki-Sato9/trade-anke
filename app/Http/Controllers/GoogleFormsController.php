<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Forms;

class GoogleFormsController extends Controller
{
    //
    public function test(Request $request)
    {
        // dd(config_path());
        $client = new Google_Client();
        // $client->setAuthConfig('/config/google_client_secret.json');
        $client->setAuthConfig(config_path() . '/google_client_secret.json');
        // dd($request->url());
        $client->setRedirectUri($request->fullUrl());
        $client->addScope(Google_Service_Forms::FORMS_BODY);
        $client->setAccessType('offline');
        
        // 偽造防止のためにトークンを指定
        // $state = substr(base_convert(hash('sha256', uniqid()), 16, 36), 0, 40);
        
        // GoogleのOAuth2.0サーバーへリクエストを行うためのURLを作成する
        $auth_url = $client->createAuthUrl();
        
        if ($request->get('code')) {
            $code = $request->get('code');
            // $client->
        }
        
        return view('static_pages.test')
            ->with(['auth_url' => $auth_url]);
    }
}
