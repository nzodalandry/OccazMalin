<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class CategoriesFixtures extends Fixture implements OrderedFixtureInterface
{
    const CATEGORIES = [
        ["Immobilier", "#00FF00"],
        ["Auto / Moto", "#F6B26B"],
        ["High-Tech", "#CC0000"],
        ["Spiritueux", "#660000"],
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIES as $key => $value)
        {
            $category = new Categories;
            $category->setName( $value[0] );
            $category->setColor( $value[1] );
            $this->addReference('categ-'.$key, $category);
            $manager->persist($category);
        }
    
        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 1;
    }
}
