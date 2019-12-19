<?php

namespace App\DataFixtures;

use App\Entity\Users;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UsersFixtures extends Fixture implements OrderedFixtureInterface
{
    const USERS = [
        [
            'firstname' => "John",
            'lastname' => "DOE",
            'email' => "john@doe.com",
            'password' => "123456",
            'language' => "fr",
        ],
        [
            'firstname' => "Jane",
            'lastname' => "DOE",
            'email' => "jane@doe.com",
            'password' => "123456",
            'language' => "fr",
        ],
        [
            'firstname' => "Bob",
            'lastname' => "DOE",
            'email' => "bob@doe.com",
            'password' => "123456",
            'language' => "fr",
        ]
    ];
    
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::USERS as $key => $value)
        {
            $user = new Users;

            $password = $this->encoder->encodePassword($user, $value['password']);

            $user->setFirstname( $value['firstname'] );
            $user->setLastname( $value['lastname'] );
            $user->setEmail( $value['email'] );
            $user->setPassword( $password );
            $user->setLanguage( $value['language'] );
            $user->setBirthday( new \DateTime() );
            // $user->setRoles(['ADMIN']);
            $user->setIsActive( true );

            $this->addReference($value['email'] , $user);
            $manager->persist($user);
        }

        $manager->flush();
    }
    
    /**
     * Get the order of this fixture
     * @return integer
     */
    public function getOrder()
    {
        return 2;
    }
}
