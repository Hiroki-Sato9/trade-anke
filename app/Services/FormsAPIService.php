<?php
namespace App\Services;

use Google_client;
use Google_Service_Forms;

class FormsAPIService
{
    public $client;
    public $service;
    private $form_id;
    
    public function __construct($form_url, $redirect_uri)
    {
        $this->init($form_url, $redirect_uri);
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
        $pre = '|https://docs.google.com/forms/d/e/';
        $suf = '/viewform|';
        preg_match($pre . '(.+)' . $suf, $url, $data);
        
        return $data[1];
    }
}