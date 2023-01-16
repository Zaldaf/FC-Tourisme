<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 15; $i++) {
            $user = new User();
            $user->setPrenom($faker->firstName)
                ->setNom($faker->lastName);
            $nbalea = $faker->numberBetween(0,1);
            if ($nbalea == 1){
                $user->setPseudo($faker->word);
            }
            $user->setEmail($faker->email)
                ->setPassword(password_hash('azerty123',PASSWORD_BCRYPT))
                ->setCreatedAt($faker->dateTimeBetween('-6 months'));

            $bool = $faker ->numberBetween(0,1);

            if ($bool == 0){
                $user->setActif(0);
            }else{
                $user->setActif(1);
            }
            $user->setRoles(['ROLE_USER']);

            $manager->persist($user);

        }
        $manager->flush();
    }
}
