<?php

namespace App\DataFixtures;


use App\Entity\Rencontre;
use Faker\Factory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RencontreFixtures extends Fixture
{
  public function load(ObjectManager $manager): void
  {
    $faker = Factory::create('fr_FR');

    for ($i = 0; $i < 20; $i++) {
      $rencontre = new Rencontre();
      $rencontre->setEvenement($this->getReference('event' . $faker->numberBetween(0, 19)));

      $idEquipeA = $faker->numberBetween(0, 19);
      $idEquipeB = $faker->numberBetween(0, 19);

      while ($idEquipeA == $idEquipeB) {
        $idEquipeA = $faker->numberBetween(0, 19);
      }

      $rencontre->setEquipeA($this->getReference('team' . $idEquipeA));
      $rencontre->setEquipeB($this->getReference('team' . $idEquipeB));

      $isTerminated = $faker->boolean();
      if ($isTerminated) {
        $rencontre->setState('terminated');
        $idEquipeA > $idEquipeB ? $rencontre->setResultat($this->getReference('team' . $idEquipeA)) : $rencontre->setResultat($this->getReference('team' . $idEquipeB));
      } else {
        $rencontre->setState('not_terminated');
      };


      $manager->persist($rencontre);
      //$this->addReference('team' . $i, $equipe);
    }

    $manager->flush();
  }
}
