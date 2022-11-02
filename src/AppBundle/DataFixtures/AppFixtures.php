<?php

namespace AppBundle\DataFixtures;


//use Doctrine\Persistence\ObjectManager;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
//use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureInterface;

class AppFixtures implements Fixture //ORMFixtureInterface //AbstractFixture implements OrderedFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setUserName('username'.$i);
            $password = $this->encoder->encodePassword($user, 'password');
            $user->setPassword($password);
            $user->setEmail($i."username@free.fr");
            $manager->persist($user);
        }

        $manager->flush();
    }
 
  
}
