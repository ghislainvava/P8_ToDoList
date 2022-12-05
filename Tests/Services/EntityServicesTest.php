<?php

namespace Tests\Services;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use App\services\EntityServices;
use Doctrine\ORM\EntityManagerInterface;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\User\UserInterface;

class EntityServicesTest extends KernelTestCase
{
    public function testManager()
    {
        
        $em = $this->createMock(EntityManagerInterface::class);
     
        $task = new Task();
        $user = $this->createMock(User::class);

        $taskService = new EntityServices($em);
        

        $em->expects($this->once())
            ->method('persist')
            ->with($task);

        $em->expects($this->once())
            ->method('flush');
        $taskService->eManager($task, $user); 
        $this->assertEquals($user, $task->getUser());
    }
}
