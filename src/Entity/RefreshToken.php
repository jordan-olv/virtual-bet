<?php

namespace App\Entity;

use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gesdinet\JWTRefreshTokenBundle\Entity\RefreshToken as BaseRefreshToken;

#[ORM\Entity]
#[ORM\Table(name: 'refresh_token')]
class RefreshToken extends BaseRefreshToken
{
  #[ORM\Column]
  private ?\DateTimeImmutable $createdAt = null;

  #[ORM\Column]
  private ?\DateTimeImmutable $updatedAt = null;

  public function __construct()
  {
    $this->createdAt = new DateTimeImmutable();
    $this->updatedAt = new DateTimeImmutable();
  }

  public function getId(): int|string|null
  {
    return $this->id;
  }

  public function getCreatedAt(): ?\DateTimeImmutable
  {
    return $this->createdAt;
  }

  public function setCreatedAt(\DateTimeImmutable $createdAt): static
  {
    $this->createdAt = $createdAt;

    return $this;
  }

  public function getUpdatedAt(): ?\DateTimeImmutable
  {
    return $this->updatedAt;
  }

  public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
  {
    $this->updatedAt = $updatedAt;

    return $this;
  }
}
