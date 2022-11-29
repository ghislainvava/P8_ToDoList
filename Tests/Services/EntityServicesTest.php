<?php

namespace Tests\Services;

use App\Entity\Task;
use App\services\EntityServices;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Security\Core\User\UserInterface;
use PHPUnit\Framework\TestCase;
use Hautelook\AliceBundle\PhpUnit\ReloadDatabaseTrait;

// class EntityServicesTest extends KernelTestCase
// {
//     public function eManagertest()
//     {
        
//         $em = $this->createMock(EntityManagerInterface::class);
//         dump($em);
//         $task = new Task();
//         $user = $this->createMock(UserInterface::class);

//         $taskService = new EntityServices($em);
//         $taskService->eManager($task, $user);

//         $this->assertEquals($user, $task->getUser());

//         // $em->expects($this->once())
//         //     ->method('persist')
//         //     ->with($task);

//         // $em->expects($this->once())
//         //     ->method('flush');
//     }
// }
class ToDoListServiceTest extends TestCase
{
    private $user;
    private $toDoListService;
    private $toDoListRepository;
    private $itemService;
    private $userService;
    private $mailService;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->createMock(User::class);

        $entityManager = $this->createMock(EntityManagerInterface::class);
        $this->itemService = $this->createMock(ItemService::class);
        $this->userService = $this->createMock(UserService::class);
        $this->mailService = $this->createMock(MailService::class);
        
        $this->toDoListService = new ToDoListService(
            $entityManager, 
            $this->itemService, 
            $this->mailService, 
            $this->userService
        );

        $this->toDoListRepository = $this->createMock(ToDoListRepository::class);
        
        $entityManager->expects($this->any())
            ->method('getRepository')
            ->willReturn($this->toDoListRepository);
    }

    public function getNewTodoList()
    {
        $todoList = new ToDoList($this->user);
        $todoList->setName("nom");
        $todoList->setDescription("description");
        
        return $todoList;
    }

    public function getNewItem()
    {
        $item = new Item();
        $item->setName("itemName");
        $item->setContent("itemContent");
        
        return $item;
    }

    public function getTodoListWithItem(Int $nbItem)
    {
        $todoList = $this->getNewTodoList();

        for ($i = 0; $i < $nbItem; $i++) {
            $item = $this->getNewItem();
            $item->setToDoList($todoList);
            $todoList->getItems()->add($item);
        }  
     
        return $todoList;
    }


    /********************  createToDoList()  ***********************/
    /** 
     * test la création d'une ToDoList valide
     * 
     * @test 
     */
    public function testCreateValidToDoList()
    {
        // pas d'erreur : valide
        $this->userService->expects($this->any())
            ->method('isValid')
            ->willReturn([]);

        // aucune todolist n'existe pour l'utilisateur
        $this->toDoListRepository->expects($this->any())
        ->method('findOneByUserId')
        ->willReturn(null);

        // On attend que la méthode nous retourne notre todoList 
        $this->assertInstanceOf(
            ToDoList::class, 
            $this->toDoListService->createToDoList($this->user, "Ma première ToDoList", "Une superbe ToDoList")
        );
    }

    /** 
     * test la création d'une ToDoList avec un user non valide
     * 
     * @test 
     */
    public function testCreateToDoListUserNotValid()
    {
        // todoList non valide car user non valide
        $this->userService->expects($this->any())
            ->method('isValid')
            ->willReturn(['error']);

        // aucune todolist n'existe pour l'utilisateur
        $this->toDoListRepository->expects($this->any())
        ->method('findOneByUserId')
        ->willReturn(null);

        $this->expectException(Exception::class);
        $this->toDoListService->createToDoList($this->user, "Ma première ToDoList", "Une superbe ToDoList");
    }

    /** 
     * Test si une todoList existe déjà pour l'utilisateur
     * 
     * @test 
     */
    public function testToDoListAlreadyExist()
    {
        // pas d'erreur : valide
        $this->userService->expects($this->any())
            ->method('isValid')
            ->willReturn([]);

        $todoList = $this->getNewTodoList();

        // une todoList existe déjà pour l'utilisateur
        $this->toDoListRepository->expects($this->any())
            ->method('findOneByUserId')
            ->willReturn($todoList);

        $this->expectException(Exception::class);
        $this->toDoListService->createToDoList($this->user, "Ma première ToDoList", "Une superbe ToDoList");
    }


    /********************  addItem()  ***********************/

    /** 
     * Test ajout d'un item sans erreur
     * 
     * @test 
     */
    public function testAddItemWithoutError()
    {
        $todoList = $this->getNewTodoList();
        $todoList->setLastAddedTime(Carbon::create(2000, 1, 1, 0, 0, 0));
        $item = $this->getNewItem();

        $this->itemService->expects($this->any())
            ->method('isValid')
            ->willReturn([]);
        
        $this->mailService->expects($this->any())
            ->method('envoieMail')
            ->willReturn(true);

        $this->toDoListRepository->expects($this->any())
            ->method('updateToDoList')
            ->willReturn($todoList);

        $todoList = $this->toDoListService->addItem($todoList, $item);

        $item->setToDoList($todoList);
        
        $this->assertContains($item, $todoList->getItems()->getValues());
    }

    /********************  isValid()  ***********************/

    /** 
     * Vérifie que la todolist est valide
     * 
     * @test 
     */ 
    public function testIsToDoListValid() {
        $todoList = $this->getNewTodoList();
        $this->assertEmpty($this->toDoListService->isValid($todoList));
    }

    /** 
     * Vérifie que le nom de la ToDoList est empty
     * 
     * @test 
     */ 
    public function testNameToDoListEmpty() {
        $todoList = $this->getNewTodoList();
        $todoList->setName("");
        $this->assertNotEmpty($this->toDoListService->isValid($todoList));
    }

    /** 
     * Vérifie que la description de la ToDoList est empty
     * 
     * @test 
     */ 
    public function testDescriptionToDoListEmpty() {
        $todoList = $this->getNewTodoList();
        $todoList->setDescription("");
        $this->assertNotEmpty($this->toDoListService->isValid($todoList));
    }


    /********************  removeItem()  ***********************/
    /** 
     * Vérifie la suppression d'un élément dans une todoList
     * 
     * @test 
     */
    public function testRemoveElement() {
        $todoList = $this->getTodoListWithItem(3);

        $item = $todoList->getItems()->get(2);
        $this->toDoListService->removeItem($todoList, $item);

        $this->assertNotContains($item, $todoList->getItems()->getValues());
    }

    /** 
     * Vérifie la suppression d'un élément qui n'existe dans une todoList
     * 
     * @test 
     */
    public function testRemoveNotExistingElement()
    {
        $todoList = $this->getTodoListWithItem(3);

        $item = $this->getNewItem();

        $this->assertNull($this->toDoListService->removeItem($todoList, $item));
    }



    /********************  checkTimeBetweenAdding()  ***********************/
    /** 
     * Test ajout d'un item avec un délai trop court entre deux ajouts
     * 
     * @test 
     */
    // public function testAddItemWithDelayError()
    // {
    //     $todoList = $this->getNewTodoList();
    //     $todoList->setLastAddedTime(Carbon::now());

    //     $this->itemService->expects($this->any())
    //         ->method('isValid')
    //         ->willReturn([]);

    //     $this->mailService->expects($this->any())
    //         ->method('envoieMail')
    //         ->willReturn(true);

    //     $this->toDoListRepository->expects($this->any())
    //         ->method('updateToDoList')
    //         ->willReturn($todoList);

    //     $item = $this->getNewItem();
        
    //     $this->expectException(Exception::class);
    //     // $this->assertTrue($this->toDoListService->addItem($todoList, $item));
    //     $todoList = $this->toDoListService->addItem($todoList, $item);
    // }


    /********************  checkIsToDoListFull()  ***********************/
    /** 
     * Test ajout d'un item à une todolist pleine
     * 
     * @test 
     */
    // public function testAddItemWithTodoListFull()
    // {
    //     $todoList = $this->getTodoListWithItem(10);
    //     $todoList->setLastAddedTime(Carbon::now());

    //     $this->itemService->expects($this->any())
    //         ->method('isValid')
    //         ->willReturn([]);

    //     $this->mailService->expects($this->any())
    //         ->method('envoieMail')
    //         ->willReturn(true);

    //     $this->toDoListRepository->expects($this->any())
    //         ->method('updateToDoList')
    //         ->willReturn($todoList);

    //     $item = $this->getNewItem();

    //     $this->expectException(Exception::class);
    //     $todoList = $this->toDoListService->addItem($todoList, $item);
    // }

}