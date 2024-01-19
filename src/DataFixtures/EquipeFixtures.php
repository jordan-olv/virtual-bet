<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EquipeFixtures extends Fixture
{
  private UserPasswordHasherInterface $hasher;

  public function __construct(UserPasswordHasherInterface $hasher)
  {
    $this->hasher = $hasher;
  }

  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('fr_FR');

    for ($i = 0; $i < 20; $i++) {
      $equipe = new Equipe();
      $equipe->setLibelle("Team " . $faker->word());
      $manager->persist($equipe);
      $this->addReference('team' . $i, $equipe);
    }

    $manager->flush();
  }
}
