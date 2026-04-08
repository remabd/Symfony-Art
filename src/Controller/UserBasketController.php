<?php

namespace App\Controller;

use App\Entity\Art;
use App\Entity\ArtBasket;
use App\Entity\Basket;
use App\Repository\ArtBasketRepository;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/basket')]
#[IsGranted('ROLE_USER')]
final class UserBasketController extends AbstractController
{
    #[Route('', name: 'app_my_basket', methods: ['GET'])]
    public function show(BasketRepository $basketRepository): Response
    {
        $basket = $basketRepository->findOneBy(['user' => $this->getUser()]);

        return $this->render('basket/my_basket.html.twig', [
            'basket' => $basket,
        ]);
    }

    #[Route('/add/{id}', name: 'app_basket_add', methods: ['POST'])]
    public function add(Art $art, BasketRepository $basketRepository, ArtBasketRepository $artBasketRepository, EntityManagerInterface $em, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('basket_add_' . $art->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        $basket = $basketRepository->findOneBy(['user' => $user]);

        if (!$basket) {
            $basket = new Basket();
            $basket->setUser($user);
            $em->persist($basket);
        }

        $artBasket = $artBasketRepository->findOneBy(['basket' => $basket, 'art' => $art]);

        if ($artBasket) {
            $artBasket->setAmount($artBasket->getAmount() + 1);
        } else {
            $artBasket = new ArtBasket();
            $artBasket->setArt($art);
            $artBasket->setAmount(1);
            $artBasket->setBasket($basket);
            $em->persist($artBasket);
        }

        $em->flush();

        return $this->redirectToRoute('app_home');
    }

    #[Route('/remove/{id}', name: 'app_basket_remove', methods: ['POST'])]
    public function remove(ArtBasket $artBasket, EntityManagerInterface $em, Request $request): Response
    {
        if (!$this->isCsrfTokenValid('basket_remove_' . $artBasket->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        if ($artBasket->getBasket()->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        $em->remove($artBasket);
        $em->flush();

        return $this->redirectToRoute('app_my_basket');
    }
}
