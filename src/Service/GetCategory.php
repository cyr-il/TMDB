<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class GetCategory
{

    public function __construct(HttpClientInterface $httpClient , ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }


    public function getMoviesByCategory()
    {
        $apiKey = $this->params->get('API_KEY');

        
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/genre/movie/list?api_key='.$apiKey.'&language=fr-FR&page=1');
        $categories = $response->toArray();
        return $categories;
    }

    public function getMoviesByCategoryDetail($id)
    {
        $apiKey = $this->params->get('API_KEY');

        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/discover/movie?api_key='.$apiKey.'&language=fr-FR&page=1&with_genres='.$id);
        $categories = $response->toArray();
        $movieByGenre = $categories['results'];
        return $movieByGenre;
    }

}
