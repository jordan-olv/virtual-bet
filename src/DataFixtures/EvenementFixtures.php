<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class EvenementFixtures extends Fixture
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
      $evenement = new Evenement();
      $evenement->setLibelle("Event " . $faker->word());
      $manager->persist($evenement);
      $this->addReference('event' . $i, $evenement);
    }

    $manager->flush();
  }
}
