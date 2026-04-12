<?php

namespace App\Controller;

use App\Entity\Art;
use App\Form\ArtType;
use App\Repository\ArtRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/admin/art')]
final class ArtController extends AbstractController
{
    #[Route(name: 'app_art_index', methods: ['GET'])]
    public function index(ArtRepository $artRepository): Response
    {
        return $this->render('art/index.html.twig', [
            'art' => $artRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_art_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $art = new Art();
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('art_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $art->setPicture($newFilename);
            }

            $entityManager->persist($art);
            $entityManager->flush();

            return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('art/new.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_show', methods: ['GET'])]
    public function show(Art $art): Response
    {
        return $this->render('art/show.html.twig', [
            'art' => $art,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_art_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Art $art, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $form = $this->createForm(ArtType::class, $art);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureFile = $form->get('picture')->getData();
            if ($pictureFile) {
                $originalFilename = pathinfo($pictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $pictureFile->guessExtension();

                try {
                    $pictureFile->move(
                        $this->getParameter('art_pictures_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }

                $art->setPicture($newFilename);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('art/edit.html.twig', [
            'art' => $art,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_delete', methods: ['POST'])]
    public function delete(Request $request, Art $art, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $art->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($art);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_art_index', [], Response::HTTP_SEE_OTHER);
    }
}
