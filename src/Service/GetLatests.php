<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetLatests
{

    public function __construct(HttpClientInterface $httpClient , ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }


    public function getLatests()
    {
        $apiKey = $this->params->get('API_KEY');

        
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/now_playing?api_key='.$apiKey.'&language=fr-FR&page=1&primary_release_year=2022');
        $latests = $response->toArray();
        $now_playing = ($latests['results']);
        
        return $now_playing;
    }

}

