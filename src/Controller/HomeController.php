<?php

namespace App\Controller;

use App\Entity\Art;
use app\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/')]
final class HomeController extends AbstractController
{
    #[Route(name: 'app_home', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            'home.html.twig',
            []
        );
    }
}
