<?php

namespace Arnaud\ToDoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Arnaud\ToDoBundle\Manager\TaskManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Doctrine\ORM\EntityManager;

/**
* Class TaskrController
*
* @Route(
* "",
* service = "arnaud.task"
* )
*/
class TaskController
{
    protected $entityManager;
    protected $taskManager;

    public function __construct(
        EntityManager $entityManager,
        TaskManager $taskManager
    )
    {
        $this->entityManager = $entityManager;
        $this->taskManager = $taskManager;
    }

    /**
     * @Route("/tasks/")
     * @Template()
     */
    public function indexAction()
    {
        $tasks = $this->entityManager->getRepository('ArnaudToDoBundle:Task')->findAll();

        return array('tasks' => $tasks);
    }

    /**
     * @Route("/task/create")
     * @Template()
     */
    public function createAction()
    {
        $tasks = $this->taskManager->createTask();

        return array('tasks' => $tasks);
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
