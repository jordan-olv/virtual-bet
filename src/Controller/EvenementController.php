<?php

namespace App\Controller;

use App\Entity\EquipeEvenement;
use App\Entity\Evenement;
use App\Repository\EquipeRepository;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/evenement')]
class EvenementController extends AbstractController
{
    #[Route('/', name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository, SerializerInterface $serializer): JsonResponse
    {
        $evenements = $evenementRepository->findAll();
        $jsonEvenements = $serializer->serialize($evenements, 'json', ['groups' => ['evenement_details', 'equipe_infos']]);

        return new JsonResponse($jsonEvenements, Response::HTTP_OK, [], true);
    }

    //Add equipe to evenement
    #[Route('/add_equipe', name: 'app_evenement_add_equipe', methods: ['POST'])]
    public function addEquipe(Request $request, EntityManagerInterface $entityManager, EvenementRepository $evenementRepository, EquipeRepository $equipeRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $evenement = $evenementRepository->find($data['evenement_id']);
        $equipe = $equipeRepository->find($data['equipe_id']);

        if (!$evenement) {
            return new JsonResponse(['error' => 'Evenement not found'], Response::HTTP_NOT_FOUND);
        }

        $equipeIsAlreadyIn = $evenement->getEquipeEvenements()->get($data['equipe_id']);

        if ($equipeIsAlreadyIn) {
            return new JsonResponse(['error' => 'Equipe already added'], Response::HTTP_BAD_REQUEST);
        }

        $equipeEvenement = new EquipeEvenement();
        $equipeEvenement->setEquipe($equipe);
        $equipeEvenement->setEvenement($evenement);
        $entityManager->persist($equipeEvenement);

        $evenement->addEquipeEvenement($equipeEvenement);
        $entityManager->persist($evenement);

        $entityManager->flush();

        return new JsonResponse($data);
    }


    #[Route('/new', name: 'app_equipe_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $equipe = new Equipe();
        $form = $this->createForm(EquipeType::class, $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($equipe);
            $entityManager->flush();

            return $this->redirectToRoute('app_equipe_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('equipe/new.html.twig', [
            'equipe' => $equipe,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_equipe_show', methods: ['GET'])]
    public function show(Evenement $evenement, SerializerInterface $serializer): Response
    {

        $jsonEvenement = $serializer->serialize($evenement, 'json', ['groups' => ['evenement_details', 'equipe_infos', 'user_details']]);

        return new JsonResponse($jsonEvenement, Response::HTTP_OK, [], true);
    }
}
