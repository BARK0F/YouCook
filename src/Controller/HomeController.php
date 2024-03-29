<?php

namespace App\Controller;

use App\Repository\RecipeRepository;
use App\Repository\RecipesCategoryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_home_page');
    }

    #[Route('/home', name: 'app_home_page')]
    public function home(RecipesCategoryRepository $recipesCategoryRepository, RecipeRepository $recipeRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $recipes = $recipeRepository->searchRecipe($search);

        return $this->render('home/index.html.twig', [
            'categories' => $recipesCategoryRepository->findAll(),
            'recipes' => $recipes,
        ]);
    }
}
