<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class Appfixtures extends Fixture
{
    public function load(ObjectManager $manager): void
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
