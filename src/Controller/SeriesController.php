<?php

namespace App\Controller;

use App\Service\GetTVShow;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class SeriesController extends AbstractController
{
    /**
     * @Route("/series", name="series")
     */
    public function index(GetTVShow $tvShow, Request $request): Response
    {
        $search = $request->query->get('serie');
        return $this->render('series/index.html.twig', [
            'controller_name' => 'HomeController',
            'series' => $tvShow->getTvShow($search),
        ]);
    }

       /**
     * @Route("/serie/{id}", name="serie_detail")
     */

    public function movieDetail($id, GetTVShow $tvShow): Response
    {
        $showDetail = $tvShow->getTvShowDetail($id);
        $characters = $tvShow->getTvCharacter($id);
        $videos = $tvShow->getTvVideo($id);
        return $this->render('series/serie_detail.html.twig', [
         'showDetail' => $showDetail,
         'characters'=> $characters,
         'videos' => $videos,
         ]);
    }
}
