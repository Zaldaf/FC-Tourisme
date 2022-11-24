<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Repository\CategorieRepository;
use App\Repository\VilleRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\String\Slugger\SluggerInterface;

class EtablissementFixtures extends Fixture
{
    private SluggerInterface $slugger;
    private VilleRepository $villeRepository;
    private CategorieRepository $categorieRepository;

    public function __construct(SluggerInterface $slugger, VilleRepository $villeRepository, CategorieRepository $categorieRepository)
    {
        $this->slugger = $slugger;
        $this->villeRepository = $villeRepository;
        $this->categorieRepository = $categorieRepository;
    }


    public function load(ObjectManager $manager): void
    {
        $ville = $this->villeRepository->findAll();
        $minVille = min($ville);
        $maxVille = max($ville);
        $categorie = $this->categorieRepository->findAll();
        $minCategorie = min($categorie);
        $maxCategorie = max($categorie);
        $faker = Factory::create("fr_FR");
        for ($i = 0; $i <= 600; $i++) {
            $etablissement = new Etablissement();
            $etablissement->setNom($faker->realText(12, 5))
                ->setSlug($this->slugger->slug($etablissement->getNom())->lower())
                ->setNumeroTelephone($faker->phoneNumber())
                ->setVille($this->villeRepository->find($faker->numberBetween($minVille->getId(), $maxVille->getId())))
                ->setAdressePostale($faker->streetAddress())
                ->setAdresseMail($faker->email)
                ->setImage($faker->imageUrl('180', '180', 'ville', 'true'))
                ->setActif($faker->boolean())
                ->setAccueil($faker->boolean())
                ->setCreateAd($faker->dateTimeBetween('-10 week', '+10 week'))
                ->setUpdatedAT($faker->dateTimeBetween('-8 week'))
                ->setDescription($faker->paragraphs(3, true))
                //doit avoir plusieur catégorie
                ->addCategorie($this->categorieRepository->find($faker->numberBetween($minCategorie->getId(), $maxCategorie->getId())))
                ->addCategorie($this->categorieRepository->find($faker->numberBetween($minCategorie->getId(), $maxCategorie->getId())));
            $manager->persist($etablissement);
        }


        $manager->flush();
    }
}
