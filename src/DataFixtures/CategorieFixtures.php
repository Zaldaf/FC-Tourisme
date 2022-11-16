<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CategorieFixtures extends Fixture
{

    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create("fr_FR");
        $categories = ["restaurant","hôtel","gîte","musée","artisan"];
        foreach ($categories as $category){
            $categorie = new Categorie();
            $categorie->setNom($category);
            $categorie->setCreateAD($faker->dateTimeBetween("-6 months"));
             $manager->persist($categorie);
        }



        $manager->flush();
    }
}
