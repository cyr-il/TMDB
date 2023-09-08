<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


class GetCharacterDetail
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient, ParameterBagInterface $params)
    {
        $this->httpClient = $httpClient;
        $this->params = $params;
    }

    public function getCharacterDetail($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/person/'.$id.'?api_key='.$apiKey);
        $characterDetail = $response->toArray();
        $birthdayDate = new \DateTime($characterDetail['birthday']);
        if($characterDetail['deathday'] != null)
        {
            $deathdayDate = new \DateTime($characterDetail['deathday']);
            $age = $birthdayDate->diff($deathdayDate)->y;
        }
        else
        {
            $age = $birthdayDate->diff(new \DateTime('today'))->y;
        }
        $characterDetail['age'] = $age;
        
        return $characterDetail;
    }

    public function getCharacterMovies($id)
    {
        $apiKey = $this->params->get('API_KEY');
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/person/'.$id.'/movie_credits?api_key='.$apiKey);
        $characterMovie = $response->toArray();
        $characterMovies = ($characterMovie['cast']);

        

        return $characterMovies;
    }


    public function searchForActor($search)
    {
        $apiKey = $this->params->get('API_KEY');
        if($search)
        {
            $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/search/person?api_key='.$apiKey.'&query='.$search);
            $actors = $response->toArray();
            $actor = ($actors['results']);
            return $actor;
        }
    }

}
