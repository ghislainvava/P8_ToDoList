<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Task;
use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture 
{


    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
            $user = new User();
            $user->setUserName('username'.$i);
            $password = $this->container->get('security.password_encoder')->encodePassword($user, $user->getPassword());
            $user->setPassword($password);
            $user->setEmail($i."username@free.fr");
            $manager->persist($user);
        }

        $manager->flush();

        for ($i = 0; $i < 10; $i++) {
            $task = new Task();
            $task->setTitle('je fais un task'.$i);
            $task->setContent("je note n'importe quoi".$i);
            $manager->persist($task);
        }
        $manager->flush();
    }

  
}
