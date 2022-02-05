<?php

namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetTVShow
{
    private $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function getTvShow($search)
    {
        if($search)
        {
            $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/search/tv?api_key=c0f31ba06e99ef09e7cf80d19f909a10&query='.$search);
            $tvShows = $response->toArray();
            $tvShow = ($tvShows['results']);
            return $tvShow;
        }

    }

    public function getTvShowDetail($id)
    {
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'?api_key=c0f31ba06e99ef09e7cf80d19f909a10');
        $showDetail = $response->toArray();
        //dd($movieDetail);
        return $showDetail;

    }

    public function getTvCharacter($id)
    {
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'/credits?api_key=c0f31ba06e99ef09e7cf80d19f909a10');
        $characters = $response->toArray();
        $character = ($characters['cast']);
        return $character;
    }

    public function getTvVideo($id)
    {
        $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/tv/'.$id.'/videos?api_key=c0f31ba06e99ef09e7cf80d19f909a10');
        $videos = $response->toArray();
        $video = ($videos['results']);
        return $video;
    }
}
