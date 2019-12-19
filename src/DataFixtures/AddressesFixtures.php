<?php

namespace App\DataFixtures;

use App\Entity\Addresses;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class AddressesFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $address = new Addresses();
        $address->setAddress("1 rue du coin qui tourne");
        $address->setPostalcode("59000");
        $address->setCity("Lille");
        $address->setCountry("FR");
        $this->addReference("address-1", $address);
        $manager->persist($address);

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
