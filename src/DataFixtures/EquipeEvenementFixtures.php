<?php

namespace App\DataFixtures;

use App\Entity\EquipeEvenement;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class EquipeEvenementFixtures extends Fixture implements DependentFixtureInterface
{
  public function load(ObjectManager $manager): void
  {

    for ($i = 0; $i < 20; $i++) {
      $equipeEvenement = new EquipeEvenement();

      $equipeEvenement->setEquipe($this->getReference('team' . rand(0, 19)));
      $equipeEvenement->setEvenement($this->getReference('event' . rand(0, 19)));
      $manager->persist($equipeEvenement);
      $this->addReference('equipeEvenement' . $i, $equipeEvenement);
    }

    $manager->flush();
  }

  public function getDependencies()
  {
    return [
      EquipeFixtures::class, // Classe de fixtures dont dépend UserProjetsFixtures
      EvenementFixtures::class, // Classe de fixtures dont dépend UserProjetsFixtures
    ];
  }
}
