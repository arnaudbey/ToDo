<?php

namespace Arnaud\ToDoBundle\Controller;

use Arnaud\ToDoBundle\Manager\TaskManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManager;

/**
* Class TaskrController
*
* @Route(
*   "",
*   service = "arnaud.task"
* )
*/
class TaskController
{
    protected $entityManager;
    protected $taskManager;
    protected $router;

    public function __construct(
        EntityManager $entityManager,
        TaskManager $taskManager,
        RouterInterface $router
    )
    {
        $this->entityManager = $entityManager;
        $this->taskManager = $taskManager;
        $this->router = $router;
    }

    /**
     * @Route("/tasks/", name="tasks")
     * @Template()
     */
    public function indexAction()
    {
        $tasks = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->findAll();

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/task/create")
     */
    public function createAction()
    {
        $task = $this->taskManager->createTask();
        $url = $this->router->generate("task.show", array("taskId" => $task->getId()));

        return new RedirectResponse($url);
    }

    /**
     * @Route("/task/{taskId}/delete")
     * @Template()
     */
    public function deleteAction($taskId)
    {
        $task = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->find($taskId);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        $url = $this->router->generate("tasks", array());

        return new RedirectResponse($url);
    }

    /**
     * @Route("/task/{taskId}", name="task.show")
     * @Template()
     */
    public function showAction($taskId)
    {
        $task = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->find($taskId);

        return array('task' => $task);
    }
}
