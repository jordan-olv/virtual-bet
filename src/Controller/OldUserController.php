<?php

namespace App\Controller;

use App\Repository\DownloadedFilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class OldUserController extends AbstractController
{
    #[Route('/api/user', name: 'app.user')]
    public function index(UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->findOneBy(["id" => 14]);
        return $this->json([
            "user" => $user
        ]);
    }

    //add image to user
    #[Route('/api/user/image/{id}', name: 'app.user.image')]
    public function addImageToUser(int $id, EntityManagerInterface $entityManager, DownloadedFilesRepository $downloadedFilesRepository, UserRepository $userRepository): JsonResponse
    {
        $file = $downloadedFilesRepository->findOneBy(["id" => 1]);
        $user = $userRepository->findOneBy(["id" => $id]);
        $user->setImage($file);
        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            "user" => $user
        ]);
    }
}
