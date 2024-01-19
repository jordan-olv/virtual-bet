<?php

namespace App\DataFixtures;

use App\Entity\Equipe;
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
        $users = [];

        $publicUser = new User();
        $publicUser->setEmail("test@test");
        $publicUser->setRoles(["PUBLIC"]);
        $publicUser->setPassword($this->passwordHasher->hashPassword($publicUser, "public"));
        $manager->persist($publicUser);
        $users[] = $publicUser;

        $adminUser = new User();
        $adminUser->setEmail("admin@admin");
        $adminUser->setRoles(["ADMIN"]);
        $adminUser->setPassword($this->passwordHasher->hashPassword($adminUser, "admin"));
        $manager->persist($adminUser);
        $users[] = $adminUser;

        for ($i = 0; $i < 10; $i++) {
            $userUser = new User();
            $password = $this->faker->password(5, 10);
            $userUser->setEmail($this->faker->email . $password);
            $userUser->setRoles(["USER"]);
            $userUser->setPassword($this->passwordHasher->hashPassword($userUser, $password));
            $manager->persist($userUser);
            $users[] = $userUser;
        }

        for ($i = 0; $i < 20; $i++) {
            $equipe = new Equipe();
            $equipe->setNom("Team" . $this->faker->word);
        }




        $manager->flush();
    }
}
