<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;

class TaskController extends AbstractController
{
    #[Route("/tasks", name:"task_list", methods: ['GET'])]
    public function listAction(EntiTyManagerInterface $em)
    {
        return $this->render('task/list.html.twig', ['tasks' => $em->getRepository(Task::class)->findAll()]);
    }

    #[Route("/tasks/create", name:"task_create", methods: ['POST'])]
    public function createAction(Request $request, EntiTyManagerInterface $em)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$em = $this->getDoctrine()->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route("/tasks/{id}/edit", name:"task_edit", methods: ['PUT'])]
    public function editAction(Task $task, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTimeImmutable());
            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a bien été modifiée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    #[Route("/tasks/{id}/toggle", name:"task_toggle", methods: ['PUT'])]
    public function toggleTaskAction(Task $task, EntityManagerInterface $em)
    {

       // if ($this->getUser()) {
           
                $task->toggle(!$task->isDone());
                $em->flush();
        
                $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle())); 
            
            // } else {
            //     $this->addFlash('error', "Vous ne pouvez pas marquer cet tâche, vous n'êtes pas l'auteur");  
            // }
            return $this->redirectToRoute('homepage');
    }

    #[Route("/tasks/{id}/delete", name:"task_delete", methods: ['DELETE'])]
    public function deleteTaskAction(Task $task, TaskRepository $repoTask, Request $request, EntityManagerInterface $em)
    {
    
        $task = $repoTask->find($request->get('id'));
        $em->remove($task);
        $em->flush();

        $this->addFlash('success', 'La tâche a bien été supprimée.');

        return $this->redirectToRoute('task_list');
    }
}
