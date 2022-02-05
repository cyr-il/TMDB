<?php

namespace App\Controller;

use App\Service\GetCharacterDetail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\UX\Chartjs\Model\Chart;

class ActorController extends AbstractController
{
    /**
     * @Route("/character/{id}", name="character_detail")
     */

    public function characterDetail($id, GetCharacterDetail $characterDetail, ChartBuilderInterface $chartBuilder): Response
    {
        $character = $characterDetail->getCharacterDetail($id);
        $characterMovies = $characterDetail->getCharacterMovies($id);
        $nbOfMovies = count($characterMovies);
        $character['nbOfMovies'] = $nbOfMovies;
        $releaseDate = [];

        foreach ($characterMovies as $movie) {

            if(!array_key_exists('release_date', $movie)){
                $movie['release_date'] = 0;
            }
            else
            {
                $strToTime = strtotime($movie['release_date']);
                $releaseDate[] = date('Y', $strToTime);
                usort($releaseDate, array($this, "compareByTimeStamp"));
            }
        }
        $data[] = array_count_values($releaseDate);
        $chart = $chartBuilder->createChart(Chart::TYPE_BAR);
        $chart->setData([
            'labels' => array_keys($data[0]),
            'datasets' => [
                [
                    'label' => 'Répartition des films par date de sortie',
                    'backgroundColor' => 'rgb(255, 99, 132)',
                    'borderColor' => 'rgb(255, 99, 132)',
                    'data' => array_values($data[0]),
                ],
            ],
        ]);
         
        $chart->setOptions([
            'scales' => [
                'y' => [
                    'suggestedMin' => 0,
                    'suggestedMax' => 10,
                ],
            ],
        ]);

        return $this->render('actor/character_detail.html.twig', [
         'character' => $character,
         'characterMovies' => $characterMovies,
         'releaseDate' => $releaseDate,
         'chart' => $chart,
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
