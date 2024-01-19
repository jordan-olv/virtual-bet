<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
use App\Entity\Evenement;
use Faker\Factory;
use App\Entity\User;
use Faker\Generator;
use App\Entity\Monstre;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    /**
     * Faker
     *
     * @var Generator
     */
    private Generator $faker;

    /**
     * User Password Hasher
     *
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $passwordHasher;

    /**
     * Constructeur des fixtures
     *
     * @param UserPasswordHasherInterface $passwordHasher
     */
    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->faker = Factory::create("fr_FR");
        $this->passwordHasher = $passwordHasher;
    }

    /**
     * Loading fixtures
     *
     * @param ObjectManager $manager
     * @return void
     */
    public function load(ObjectManager $manager): void

    {
    }
}
