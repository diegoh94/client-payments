<?php

namespace App\Http\Clients;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client as GuzzleClient;

class ExchangeRateUsdClient 
{
    private $baseUrl;
    private $getClient;

    public function __construct()
    {   
        $this->baseUrl = 'https://mindicador.cl/api/dolar';
        $this->getClient = Http::get($this->baseUrl);
    }

    public function exchangeRateToUsd()
    {   
        $response = $this->getClient->getBody();
        $jsonResponse = json_decode($response, true);
        
        return $jsonResponse['serie'][1]['valor'];
    }

}