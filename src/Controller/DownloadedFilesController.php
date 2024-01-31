<?php

namespace App\Controller;

use App\Entity\DownloadedFiles;
use App\Repository\DownloadedFilesRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/image')]
class DownloadedFilesController extends AbstractController
{
    #[Route('/', name: 'app.index')]
    public function index(): void
    {
    }

    #[Route('/new', name: 'files.create', methods: ["POST"])]
    public function createFile(
        Request $request,
        DownloadedFilesRepository $repository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator
    ): JsonResponse {
        $newFile = new DownloadedFiles();

        $file = $request->files->get("file");
        $newFile->setFile($file);
        $entityManager->persist($newFile);
        $entityManager->flush();

        $realname = $newFile->getRealname();
        $realpath = $newFile->getRealpath();
        $slug = $newFile->getSlug();
        $jsonPicture = [
            "id" => $newFile->getId(),
            "name" => $newFile->getName(),
            "realname" => $realname,
            "realpath" => $realpath,
            "mimetype" => $newFile->getMimeType(),
            "slug" => $slug,
        ];
        $location = $urlGenerator->generate("app.index", [], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonPicture, Response::HTTP_CREATED, ["Location" => $location . $realpath . "/" . $slug]);
    }


    #[Route('/api/file/{id}', name: 'files.edit', methods: ["POST"])]
    public function editFile(
        int $id,
        Request $request,
        DownloadedFilesRepository $repository,
        SerializerInterface $serializer,
        EntityManagerInterface $entityManager,
        UrlGeneratorInterface $urlGenerator,
        UserRepository $userRepository
    ): JsonResponse {
        $oldFile = $repository->find($id);
        $oldFile->setStatus(false);

        $newFile = new DownloadedFiles();
        $file = $request->files->get("file");

        $newFile->setFile($file);
        $entityManager->persist($newFile);
        $entityManager->flush();

        $realname = $newFile->getRealname();
        $realpath = $newFile->getRealpath();
        $slug = $newFile->getSlug();

        $allUser = $userRepository->findAll();

        foreach ($allUser as $user) {
            if ($user->getImage() === $oldFile) {
                $user->setImage($newFile);
                $entityManager->persist($user);
                $entityManager->flush();
            }
        }

        $jsonPicture = [
            "id" => $newFile->getId(),
            "name" => $newFile->getName(),
            "realname" => $newFile->getRealname(),
            "realpath" => $newFile->getRealpath(),
            "mimetype" => $newFile->getMimeType(),
            "slug" => $slug,
        ];
        $location = $urlGenerator->generate("app.index", [], UrlGeneratorInterface::ABSOLUTE_URL);
        return new JsonResponse($jsonPicture, Response::HTTP_OK, ["Location" => $location . $file->getRealpath() . "/" . $newFile->getSlug()]);
    }
}
