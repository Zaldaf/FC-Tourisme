<?php

// src/Command/CreateUserCommand.php
namespace App\Command;

use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Statement;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use League\Csv\Reader;




#[AsCommand(
    name: 'app:import-villes-franche-comte',
    description: 'Importation de ville de la Franche-Comté',
    hidden: false

)]
class ImportVille extends Command
{
    private EntityManagerInterface $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    protected function execute(InputInterface $input,OutputInterface $output): int
    {

        $output->writeln([
            'Importation ville'
        ]);

        $csv = Reader::createFromPath('documentation/villes.csv', 'r');
        $csv->setDelimiter(';');
        $csv->setHeaderOffset(0);


        foreach ($csv as $import ) {


            if ($import['Département'] == 25 |$import['Département'] == 90 |$import['Département'] == 39 |$import['Département'] == 70){
                $ville = new Ville();
                if (empty($import['Ancienne commune'])){
                    $ville->setNom($import['Commune']);
                }else{
                    $ville->setNom($import['Commune'].'-'.$import['Ancienne commune']);
                }
                $ville->setCodePostale($import['Code postal']);
                $ville->setNomDepartement($import['Nom département']);
                $ville->setNumeroDepartement($import['Département']);
                $ville->setNomRegion($import['Région']);
                $this->manager->persist($ville);
            }
        }
        $this->manager->flush();


        return Command::SUCCESS;
    }
}