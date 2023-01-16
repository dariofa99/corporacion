<?php
namespace App\Repositories;

use GuzzleHttp\Client;

class GuzzleHttpRequest{

    public $client;
    function __construct(){
        $this->client = new Client(
            ['base_uri'=>'https://apichat.alercom.org/',
            'verify'=> false,'timeout' => 36000,
            //'auth' => [ config('env'), config('env')],
            ]
        );
       
    }

    public function get($url,$request){
       //dd(openssl_get_cert_locations());
        $response = $this->client->request('GET', $url,['json' => $request]);
       // dd($response);
        return json_decode($response->getBody()->getContents());
    }
 
    
    public function post($url,$request){
          $response = $this->client->request('POST', $url,['json' => $request]);
          return json_decode($response->getBody()->getContents());
      }
}

