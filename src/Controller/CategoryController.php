<?php

namespace App\Controller;

use App\Service\GetCategory;
use App\Service\GetCategoryDetail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/", name="category")
     */

    public function category(GetCategory $getCategory): Response
    {
        $categories = $getCategory->getMoviesByCategory();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
         ]);
    }

    /**
     * @Route("/category/?={id}", name="category_detail")
     */

    public function categoryDetail(GetCategory $getCategory, $id): Response
    {
        $categoriesDetail = $getCategory->getMoviesByCategoryDetail($id);
        $categories = $getCategory->getMoviesByCategory();
        return $this->render('category/index.html.twig', [
            'categories' => $categories,
            'categoriesDetail' => $categoriesDetail,
         ]);
    }

}
