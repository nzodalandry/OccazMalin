<?php

namespace App\DataFixtures;

use App\Entity\Ads;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AdsFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i=0; $i<10; $i++)
        {
            $ad = new Ads();
            $ad->setTitle("Ma premiere annonce");
            $ad->setDescription("Description de ma premiere annonce...");
            $ad->setPrice("99.99");
            $ad->setState("broken");
            $ad->setCategory( $this->getReference("categ-1"));
            $ad->setCreatedBy( $this->getReference("john@doe.com") );
            $ad->setLanguage( $this->getReference("john@doe.com")->getLanguage() );
            $ad->setLocation( $this->getReference("address-1") );
            $manager->persist($ad);
        }


        $ad = new Ads();
        $ad->setTitle("Ma seconde annonce");
        $ad->setDescription("Description de ma premiere annonce...");
        $ad->setPrice("99.99");
        $ad->setState("new");
        $ad->setCategory( $this->getReference("categ-2"));
        $ad->setCreatedBy( $this->getReference("bob@doe.com") );
        $ad->setLanguage( $this->getReference("bob@doe.com")->getLanguage() );
        $ad->setLocation( $this->getReference("address-1") );
        $manager->persist($ad);

        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 3;
    }
}
