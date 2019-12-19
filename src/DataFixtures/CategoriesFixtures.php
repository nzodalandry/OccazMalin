<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoriesFixtures extends Fixture
{
    // Définition des données
    const CATEGORIES = [
        ["Immobilier", "#00FF00"],
        ["Auto / Moto", "#F6B26B"],
        ["High-Tech", "#CC0000"],
        ["Spiritueux", "#660000"],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $value)
        {
            $category = new Categories;
            $category->setName( $value[0] );
            $category->setColor( $value[1] );
            $manager->persist($category);
        }

        $manager->flush();
    }
}
