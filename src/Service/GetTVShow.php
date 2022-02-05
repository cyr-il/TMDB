<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class GetTVShow
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function getTvShow($search)
    {
        $apiKey = $this->params->get('API_KEY');
        if($search)
        {
            $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/search/tv?api_key='.$apiKey.'&query='.$search);
            $tvShows = $response->toArray();
            $tvShow = ($tvShows['results']);
            return $tvShow;
        }

    }

    public function getTvShowDetail($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'?api_key='.$apiKey);
        $showDetail = $response->toArray();
        //dd($movieDetail);
        return $showDetail;

    }

    public function getTvCharacter($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'/credits?api_key='.$apiKey);
        $characters = $response->toArray();
        $character = ($characters['cast']);
        return $character;
    }

    public function getTvVideo($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'/videos?api_key='.$apiKey);
        $videos = $response->toArray();
        $video = ($videos['results']);
        return $video;
    }
}
