<?php
namespace App\Repositories;

use GuzzleHttp\Client;

class GuzzleHttpRequest{

    public $client;
    function __construct(){
        $this->client = new Client(
            ['base_uri'=>'http://apichat.amatai.net/']
        );
    }

    public function get($url,$request){
        //dd($url);
        $response = $this->client->request('GET', $url,['json' => $request]);
        //
        return json_decode($response->getBody()->getContents());
    }
 
    
    public function post($url,$request){
          $response = $this->client->request('POST', $url,['json' => $request]);
          return json_decode($response->getBody()->getContents());
      }
}

