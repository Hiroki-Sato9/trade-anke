<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Forms;

use App\Services\FormsAPIService;

class GoogleFormsController extends Controller
{
    // アクセストークンを取得し、セッションに保存する役割を担う。
    // トークンをクライアントにセットするのはそれぞれのアクション内で行われる
    public function connect(Request $request)
    {
        
        $form_service = new FormsAPIService('');
        if (!empty($request->get('code'))) {
            $token = $form_service->client->fetchAccessTokenWithAuthCode($request->get('code'), session('code_verifier'));
            session(['upload_token' => $token]);
            header('Location: ' . filter_var($form_service->redirect_uri, FILTER_SANITIZE_URL));
        } 
        
        if ($form_service->can_set_token()) {
            // 元のアクションへリダイレクト
            redirect(session('redirect_url'));
        } else {
            session()->put('redirect_url', url()->previous());
            
            session()->put('code_verifier', $form_service->client->getOAuth2Service()->generateCodeVerifier());
            $auth_url = $form_service->client->createAuthUrl();

            return redirect($auth_url);
        }
    }
    
    public function test(Request $request)
    {
        
        $form_service = new FormsAPIService('https://docs.google.com/forms/d/1-fLk6OQWXuQswmxohkYs9U3W304SF81IDg4rOWMBWPk/edit', $request->url());
        
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