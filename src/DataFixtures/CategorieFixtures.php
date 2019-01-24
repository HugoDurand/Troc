<?php

namespace App\DataFixtures;


use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategorieData() as [$libelle, $photo]) {

            $categorie = new Categorie();

            $categorie->setLibelle($libelle);
            $categorie->setPhoto($photo);

            $manager->persist($categorie);
        }

        $manager->flush();
    }

    private function getCategorieData(): array
    {
        return [
            ['Mode', 'mode.jpg'],
            ['Informatique', 'informatique.jpg'],
            ['Jardin', 'jardin.jpg'],
            ['Sport', 'sport.jpg'],
            ['Intérieur', 'interieur.jpg']
        ];
    }


}