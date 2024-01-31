<?php

namespace App\Controller;

use App\Entity\Rencontre;
use App\Form\RencontreType;
use App\Repository\RencontreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/rencontre')]
class RencontreController extends AbstractController
{
    #[Route('/', name: 'app_rencontre_index', methods: ['GET'])]
    public function index(RencontreRepository $rencontreRepository, SerializerInterface $serializer): JsonResponse
    {
        $rencontres = $rencontreRepository->findAll();
        $jsonRencontre = $serializer->serialize($rencontres, 'json', ['groups' => ['rencontre_infos', 'equipe_infos', 'pari_details_rencontre', 'user_details']]);

        return new JsonResponse($jsonRencontre, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'app_rencontre_show', methods: ['GET'])]
    public function show(Rencontre $rencontre, SerializerInterface $serializer): Response
    {
        $jsonRencontre = $serializer->serialize($rencontre, 'json', ['groups' => ['rencontre_infos', 'equipe_infos', 'pari_details_rencontre', 'user_details']]);

        return new JsonResponse($jsonRencontre, Response::HTTP_OK, [], true);
    }
}
