<?php

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Appfixtures extends Fixture
    
{
    private $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 2; $i++) {
             $user = new User();
             $palintextPassword = "password";
             $user->setUserName('username'.$i);
             $user->setEmail($i."username@free.fr");
              $user->setRoles(["ROLE_USER"]);

             $password = $this->encoder->hashPassword(
                $user,
                $palintextPassword
             );
             //$user->setPassword($this->encoder->hashPassword($user, "password"));
             $user->setPassword($password);
             
            
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
