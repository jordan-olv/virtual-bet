<?php

namespace App\Controller;

use App\Entity\DownloadedFiles;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\DownloadedFilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $users = $userRepository->findAll();

        $jsonUsers = $serializer->serialize($users, 'json', ['groups' => ['user_simple', 'user_details', 'user_stats']]);

        return new JsonResponse($jsonUsers, Response::HTTP_OK, [], true);
    }

    #[Route('/add_image', name: 'app_user_add_image', methods: ['POST'])]
    public function addImage(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, DownloadedFilesRepository $downloadedFilesRepository): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $userId = $this->getUser()->getId();
        $user = $userRepository->find($userId);

        $image = $downloadedFilesRepository->find($data['image_id']);

        if (!$image) {
            return new JsonResponse(['error' => 'Image not found'], Response::HTTP_NOT_FOUND);
        }

        $user->setImage($image);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($data);
    }

    #[Route('/{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user, SerializerInterface $serializer): JsonResponse
    {
        $jsonUser = $serializer->serialize($user, 'json', ['groups' => ['user_simple', 'user_details', 'user_stats']]);

        return new JsonResponse($jsonUser, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}/edit', name: 'app_user_edit', methods: ['PUT'])]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $user->setEmail($data['email']);

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse($data);
    }
}
