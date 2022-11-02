<?php

namespace AppBundle\DataFixtures;

use AppBundle\Entity\User;

//use Doctrine\Bundle\FixturesBundle\Fixture;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture //AbstractFixture implements OrderedFixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager): void
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
    //  public function getOrder()
    // {
    //     return 1;
    // }
  
}
