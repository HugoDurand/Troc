<?php

namespace App\DataFixtures;


use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategorieFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        foreach ($this->getCategorieData() as [$libelle]) {

            $categorie = new Categorie();

            $categorie->setLibelle($libelle);

            $manager->persist($categorie);
        }

        $manager->flush();
    }

    private function getCategorieData(): array
    {
        return [
            ['Mode'],
            ['Informatique'],
        ];
    }


}