<?php

namespace App\services;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class EntityServices {


    private EntityManagerInterface  $em;

    public function __construct(EntityManagerInterface  $em)
    {
         $this->em = $em;
        }

    public function eManager(Task $task, User $user)
    { 
        $task->setUser($user);
        $this->em->persist($task);
        $this->em->flush();
    }

    
        
}