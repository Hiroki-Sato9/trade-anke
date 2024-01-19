<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google_client;
use Google_Service_Books;

class GoogleFormsController extends Controller
{
    //
    public function test()
    {
        $client = new Google_Client();
        $client->setApplicationName("Trade-Anke");
        // $client->setDeveloperKey('YOUR_APP_KEY');
        
        $service = new Google_Service_Books($client);
        $query = 'Henry David Threau';
        $optParams = [
            'filter' => 'free-ebooks',
        ];
        $results = $service->volumes->listVolumes($query, $optParams);
        
        foreach ($results->getItems() as $item) {
            echo $item['volumeInfo']['title'], "<br /> \n";
        }
        
    }
}
