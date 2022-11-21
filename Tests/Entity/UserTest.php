<?php

namespace tests\Entity;

use App\Entity\Task;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private $user;
      public function setUp():void{
        $this->user = new User();
    }

    public function testUserUsername(): void
    {
        $username = 'username';
        $this->assertNotSame($username, $this->user->getUsername());
        $this->user->setUsername($username);
        $this->assertSame($username, $this->user->getUsername());
    }

    public function testUserPassword(): void
    {
        $userpassword = 'password';
        $this->assertNotSame($userpassword, $this->user->getPassword());
        $this->user->setPassword($userpassword);
        $this->assertSame($userpassword, $this->user->getPassword());
        $this->assertSame('password', $this->user->getPassword());
    }

    public function testUserEmail(): void
    {
        $useremail = 'email@free.fr';
        $this->assertNotSame($useremail, $this->user->getEmail());
        $this->user->setEmail($useremail);
        $this->assertSame($useremail, $this->user->getEmail());
    }


    public function testUserRole(): void
    {
        $role = ['ROLE_ADMIN'];
        $this->assertTrue(in_array('ROLE_USER', $this->user->getRoles()));
        $this->assertNotTrue(in_array('ROLE_ADMIN', $this->user->getRoles()));
        // $this->user->setRoles($role);
        // $this->assertTrue('ROLE_ADMIN', $this->user->getRoles());
        
    }
    //  public function testAuthor(): void
    // {
    //     $task = new task();

    

    //     $author = new user();

    //     $this->assertTrue($task->isAnonymous());
    //     $this->assertNotSame($author, $task->getAuthor());
    //     $task->setAuthor($author);
    //     $this->assertSame($author, $task->getAuthor());
    //     $this->assertNotTrue($task->isAnonymous());
    //     $task->setAuthor(null);
    //     $this->assertTrue($task->isAnonymous());
    //     $this->assertNotSame($author, $task->getAuthor());
    // }

}