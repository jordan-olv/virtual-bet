<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
  private UserPasswordHasherInterface $hasher;

  public function __construct(UserPasswordHasherInterface $hasher)
  {
    $this->hasher = $hasher;
  }

  public function load(ObjectManager $manager): void
  {
    //IMPORT FAKER FOR RANDOM FIXTURES
    $faker = Factory::create('fr_FR');

    $users = [];

    $publicUser = new User();
    $publicUser->setEmail("test@test");
    $publicUser->setRoles(["PUBLIC"]);
    $publicUser->setPassword($this->hasher->hashPassword($publicUser, "public"));
    $manager->persist($publicUser);

    $adminUser = new User();
    $adminUser->setEmail("admin@admin");
    $adminUser->setRoles(["ADMIN"]);
    $adminUser->setPassword($this->hasher->hashPassword($adminUser, "admin"));
    $manager->persist($adminUser);

    for ($i = 0; $i < 10; $i++) {
      $userUser = new User();
      $password = $faker->password(5, 10);
      $userUser->setEmail($faker->email() . $password);
      $userUser->setRoles(["USER"]);
      $userUser->setPassword($this->hasher->hashPassword($userUser, $password));
      $manager->persist($userUser);
      $this->addReference('user' . $i, $userUser);
    }

    $manager->flush();
  }
}
