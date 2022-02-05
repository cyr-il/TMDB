<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class GetMovie
{
    private $httpClient;
    private $params;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function getMovie($search)
    {
        $apiKey = $this->params->get('API_KEY');

        if($search)
        {
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/search/movie?api_key='.$apiKey.'&query='.$search);
        $movies = $response->toArray();
        $movie = ($movies['results']);
        return $movie;
        }

    }

    public function getMovieDetail($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/'.$id.'?api_key='.$apiKey);
        $movieDetail = $response->toArray();

        $runtime = $movieDetail['runtime'];
        $movieDetail['runtime'] = $runtime;
        //dd($movieDetail);
        return $movieDetail;

    }

    public function getCharacter($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/'.$id.'/credits?api_key='.$apiKey);
        $characters = $response->toArray();
        $character = ($characters['cast']);
        return $character;
    }

    public function getVideo($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/'.$id.'/videos?api_key='.$apiKey);
        $videos = $response->toArray();
        $video = ($videos['results']);
        return $video;
    }
}
