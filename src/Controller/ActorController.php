<?php

namespace App\Controller;

use App\Service\GetCharacterDetail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ActorController extends AbstractController
{
    /**
     * @Route("/character/{id}", name="character_detail")
     */

    public function characterDetail($id, GetCharacterDetail $characterDetail): Response
    {
        $character = $characterDetail->getCharacterDetail($id);
        $characterMovies = $characterDetail->getCharacterMovies($id);
        $nbOfMovies = count($characterMovies);
        $character['nbOfMovies'] = $nbOfMovies;
        $releaseDate = [];

        // Fonction de comparaison pour trier du plus récent au plus ancien
        $compareFunction = function($a, $b) {
            $dateA = new \DateTime($a['release_date']);
            $dateB = new \DateTime($b['release_date']);
            
            if ($dateA == $dateB) {
                return 0;
            }
            
            return ($dateA > $dateB) ? -1 : 1;
        };
        
        
        usort($characterMovies, $compareFunction);

        return $this->render('actor/character_detail.html.twig', [
         'character' => $character,
         'characterMovies' => $characterMovies,
         'releaseDate' => $releaseDate,
         ]);
    }

    /**
     * @Route("/actor", name="actor")
     */

    public function actorDetail(GetCharacterDetail $actorDetail, Request $request): Response
    {
        $search = $request->query->get('actor');
        return $this->render('actor/index.html.twig', [
            'actors' => $actorDetail->searchForActor($search),
            ]);
        
    }
}
