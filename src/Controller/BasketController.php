<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Form\BasketType;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/basket')]
final class BasketController extends AbstractController
{
    #[Route(name: 'app_basket_index', methods: ['GET'])]
    public function index(BasketRepository $basketRepository): Response
    {
        return $this->render('basket/index.html.twig', [
            'baskets' => $basketRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_basket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $basket = new Basket();
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($basket);
            $entityManager->flush();

            return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basket/new.html.twig', [
            'basket' => $basket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_basket_show', methods: ['GET'])]
    public function show(Basket $basket): Response
    {
        return $this->render('basket/show.html.twig', [
            'basket' => $basket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_basket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Basket $basket, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('basket/edit.html.twig', [
            'basket' => $basket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_basket_delete', methods: ['POST'])]
    public function delete(Request $request, Basket $basket, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $basket->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($basket);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_basket_index', [], Response::HTTP_SEE_OTHER);
    }
}
