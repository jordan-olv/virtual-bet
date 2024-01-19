<?php

namespace App\Controller;

use App\Entity\Monstre;
use App\Repository\MonstreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class MonstreController extends AbstractController
{
    #[Route('/monstre', name: 'app_monstre')]
    public function index(): JsonResponse
    {

        throw new \Exception("agagagag", 1);

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/MonstreController.php',
        ]);
    }

    #[Route('/api/monstredex', name: 'monstredex.getAll', methods: ['GET'])]
    #[IsGranted("USER", message: "Vous devez être connecté pour accéder à cette ressource")]
    public function getAllMonstre(MonstreRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $monstres = $repository->findAll(); // Datas

        $jsonMonstre = $serializer->serialize($monstres, 'json', [], true);
        return new JsonResponse($jsonMonstre, Response::HTTP_OK);
    }

    #[Route('/api/monstredex/{id}', name: 'monstredex.get', methods: ['GET'])]
    public function getMonstre(int $id, MonstreRepository $repository, SerializerInterface $serializer): JsonResponse
    {
        $monstres = $repository->find($id); // Datas

        $jsonMonstre = $serializer->serialize($monstres, 'json', [], true);
        return new JsonResponse($jsonMonstre, Response::HTTP_OK);
    }

    #[Route('/api/monstredex/', name: 'monstredex.create', methods: ['POST'])]
    public function createMonstre(Request $request, MonstreRepository $repository, SerializerInterface $serializer, EntityManagerInterface $entityManager, UrlGeneratorInterface $urlGenerator): JsonResponse
    {
        $monstredexEntry = $serializer->deserialize($request->getContent(), Monstre::class, 'json');
        $location = $urlGenerator->generate('monstredex.get', ['id' => $monstredexEntry->getId()], UrlGeneratorInterface::ABSOLUTE_URL);
        $jsonMonstre = $serializer->serialize($monstredexEntry, 'json');
        $entityManager->persist($monstredexEntry);
        $entityManager->flush();

        return new JsonResponse($jsonMonstre, Response::HTTP_CREATED, ["Location" => $location], true);
    }

    #[Route('/api/monstredex/{id}', name: 'monstredex.delete', methods: ['DELETE'])]
    public function deleteMonstre(int $id, MonstreRepository $monstreRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $monstre = $monstreRepository->find($id);
        $entityManager->remove($monstre);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT, []);
    }

    #[Route('/api/monstredex/{id}', name: 'monstredex.update', methods: ['PATCH', 'PUT'])]
    public function updateMonstre(int $id, Request $request, MonstreRepository $monstreRepository, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $monstre = $monstreRepository->find($id);
        $updatedMonstre = $serializer->deserialize($request->getContent(), Monstre::class, 'json', [AbstractNormalizer::OBJECT_TO_POPULATE => $monstre]);
        $updatedMonstre->setUpdatedAt(new \DateTimeImmutable());
        $entityManager->persist($monstre);
        $entityManager->flush();

        return new JsonResponse(null, Response::HTTP_NO_CONTENT, []);
    }
}
