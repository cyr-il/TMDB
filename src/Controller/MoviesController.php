<?php

namespace App\Controller;

use App\Service\GetMovie;
use App\Service\GetLatests;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MoviesController extends AbstractController
{
    /**
     * @Route("/movies", name="movies")
     */
    public function index(GetMovie $getMovie, Request $request, GetLatests $getLatests): Response
    {
        $search = $request->query->get('film');
        $latests = $getLatests->getLatests();
        return $this->render('movies/index.html.twig', [
            'controller_name' => 'HomeController',
            'movie' => $getMovie->getMovie($search),
            'latests'=> $latests
        ]);
    }

     /**
     * @Route("/movie/{id}", name="movie_detail")
     */

    public function movieDetail($id, GetMovie $getMovie): Response
    {
        $movieDetail = $getMovie->getMovieDetail($id);
        $characters = $getMovie->getCharacter($id);
        $videos = $getMovie->getVideo($id);
        return $this->render('movies/movie_detail.html.twig', [
         'movieDetail' => $movieDetail,
         'characters'=> $characters,
         'videos' => $videos,
         ]);
    }
}
