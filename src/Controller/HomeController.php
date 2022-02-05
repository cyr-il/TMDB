<?php

namespace App\Controller;

use App\Service\GetMovie;
use App\Service\GetCharacterDetail;
use App\Service\GetLatests;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(GetLatests $getLatests): Response
    {
        $latests = $getLatests->getLatests();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'latests'=> $latests
        ]);
    }
}