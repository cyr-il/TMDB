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
        $currentYear = (new \DateTime())->format('Y');

        $nowFinalPlaying = [];

        for($i = 1; $i <= 3; $i++) {

            $response = $this->httpClient->request('GET', 'https://api.themoviedb.org/3/movie/now_playing?api_key='.$apiKey.'&language=fr-FR&page='.$i.'&primary_release_year='.$currentYear);
            $latests = $response->toArray();
            $now_playing = $latests['results'];
            
            // Fonction de comparaison pour trier du plus récent au plus ancien
            $compareFunction = function($a, $b) {

                if( isset($a['release_date']) && isset($b['release_date'])) {
                    $dateA = new \DateTime($a['release_date']);
                    $dateB = new \DateTime($b['release_date']);
                    
                    if ($dateA == $dateB) {
                        return 0;
                    }
                    
                    return ($dateA > $dateB) ? -1 : 1;
                }
            
            };

            $nowFinalPlaying = array_merge($nowFinalPlaying, $now_playing);
        }
        
        // Tri des résultats en utilisant la fonction de comparaison
        usort($nowFinalPlaying, $compareFunction);

        //change la date de 'Y-M-D' en 'M-D-Y'
        foreach ($nowFinalPlaying as $key => $value) {
            
            $nowFinalPlaying[$key]['release_date'] = date('d-M-Y', strtotime($value['release_date']));

        }
        
        return $nowFinalPlaying;
    }
    

}

