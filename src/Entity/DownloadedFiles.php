<?php

namespace App\Entity;

use App\Repository\DownloadedFilesRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\AsciiSlugger;

#[ORM\Entity(repositoryClass: DownloadedFilesRepository::class)]
class DownloadedFiles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $realname = null;

    #[ORM\Column(length: 255)]
    private ?string $realpath = null;

    #[ORM\Column(length: 255)]
    private ?string $publicpath = null;

    #[ORM\Column(length: 255)]
    private ?string $mimeType = null;

    private ?File $file = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\OneToOne(mappedBy: 'image', cascade: ['persist', 'remove'])]
    private ?User $user = null;


    public function __construct()
    {
        $this->setStatus(true);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getRealname(): ?string
    {
        return $this->realname;
    }

    public function setRealname(string $realname): static
    {
        $this->realname = $realname;

        return $this;
    }

    public function getRealpath(): ?string
    {
        return $this->realpath;
    }

    public function setRealpath(string $realpath): static
    {
        $this->realpath = $realpath;

        return $this;
    }

    public function getPublicpath(): ?string
    {
        return $this->publicpath;
    }

    public function setPublicpath(string $publicpath): static
    {
        $this->publicpath = $publicpath;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): static
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $slugger = new AsciiSlugger();
        $parseSlug = $slugger->slug($slug . time());
        $this->slug = $parseSlug . "." . $this->getFile()->getClientOriginalExtension();

        return $this;
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file;
    }

    public function setFile(UploadedFile $file): static
    {
        $this->file = $file;

        $this->setName($file->getClientOriginalName());
        $this->setRealname($file->getClientOriginalName());
        $this->setMimeType($file->getClientMimeType());

        $this->setPublicpath("./documents/pictures");
        $this->setRealpath("documents/pictures");
        $this->setSlug($this->getRealname());
        $file->move(
            $this->getPublicPath(),
            $this->getSlug()
        );

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setImage(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getImage() !== $this) {
            $user->setImage($this);
        }

        $this->user = $user;

        return $this;
    }
}
