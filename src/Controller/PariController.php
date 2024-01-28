<?php

namespace App\Controller;

use App\Entity\Pari;
use App\Form\PariType;
use App\Repository\EquipeRepository;
use App\Repository\PariRepository;
use App\Repository\RencontreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/pari')]
class PariController extends AbstractController
{
    #[Route('/', name: 'app_pari_index', methods: ['GET'])]
    public function index(PariRepository $pariRepository): Response
    {
        return $this->render('pari/index.html.twig', [
            'paris' => $pariRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_pari_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, RencontreRepository $rencontreRepository, EquipeRepository $equipeRepository): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        $user = $this->getUser();
        $pari = new Pari();
        $pari->setUser($user);

        $rencontre = $rencontreRepository->find($data['rencontre']);
        $pari->setRencontre($rencontre);

        $equipeChoix = $equipeRepository->find($data['equipeChoix']);


        if ($rencontre->getEquipeA() == $equipeChoix || $rencontre->getEquipeB() == $equipeChoix) {
            $pari->setEquipeChoix($equipeChoix);
        } else {
            return new JsonResponse(['error' => 'L\'équipe choisie n\'est pas dans la rencontre'], Response::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($pari);
        $entityManager->flush();

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'app_pari_show', methods: ['GET'])]
    public function show(Pari $pari): Response
    {
        return $this->render('pari/show.html.twig', [
            'pari' => $pari,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_pari_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Pari $pari, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PariType::class, $pari);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_pari_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('pari/edit.html.twig', [
            'pari' => $pari,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_pari_delete', methods: ['POST'])]
    public function delete(Request $request, Pari $pari, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $pari->getId(), $request->request->get('_token'))) {
            $entityManager->remove($pari);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_pari_index', [], Response::HTTP_SEE_OTHER);
    }
}
