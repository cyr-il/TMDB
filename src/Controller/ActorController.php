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

        foreach ($characterMovies as $movie) {
            $strToTime = strtotime($movie['release_date']);
            $releaseDate[] = date('Y', $strToTime);
        }

        usort($releaseDate, array($this, "compareByTimeStamp"));

        //dd($releaseDate);


        return $this->render('home/character_detail.html.twig', [
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

    public function compareByTimeStamp($a, $b)
    {
        if ($a == $b) {
            return 0;
        }
        return ($a < $b) ? -1 : 1;
    }

}
