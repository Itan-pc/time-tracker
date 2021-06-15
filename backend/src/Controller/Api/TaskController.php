<?php

namespace App\Controller\Api;

use App\Entity\Task;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use App\Service\FormErrorService;
use phpDocumentor\Reflection\File;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;

/**
 * @Rest\Route("/api/task")
 */
class TaskController extends AbstractFOSRestController
{
    /**
     * List all tasks.
     *
     * @Rest\Get("/", name="api_task_index")
     */
    public function listTasks(TaskRepository $taskRepository): View
    {
        $user = $this->getUser();
        $tasks = $user->getTask();
        return View::create($tasks, Response::HTTP_OK);
    }

    /**
     * Create Task
     *
     * @Rest\Post("/new", name="api_task_new")
     * @param Request $request
     * @return View
     *
     *
     */
    public function createTask(Request $request, FormErrorService $formErrorService): View
    {
        $task = new Task();
        $data = json_decode($request->getContent(), true);
        $form = $this->createForm(TaskType::class, $task);
        $form->submit($data);
        if (!$form->isValid()) {
            return View::create($formErrorService->getFormErrors($form), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if ($form->isValid()) {
            $task->setUser($this->getUser());
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return View::create($task, Response::HTTP_CREATED);
        }

        return View::create($form, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * View Task
     *
     * @Rest\Get("/show/{id}", name="api_task_show", requirements={"id"="\d+"})
     * @param Task $task
     * @return View
     */
    public function showTask(Task $task): View
    {
        return View::create($task, Response::HTTP_OK);
    }

    /**
     * Edit Task
     *
     * @Rest\Put("/edit/{id}", name="api_task_edit", requirements={"id"="\d+"})
     * @param Task $task
     * @param Request $request
     * @return View
     */
    public function editTask(Task $task, Request $request, FormErrorService $formErrorService): View
    {
        $data = json_decode($request->getContent(), true);

        $form = $this->createForm(TaskType::class, $task);
        $form->submit($data);
        if (!$form->isValid()) {
            return View::create($formErrorService->getFormErrors($form), Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return View::create($task, Response::HTTP_OK);
        }
        return View::create($task, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Delete Task
     *
     * @Rest\Delete("/remove/{id}", name="api_task_delete", requirements={"id"="\d+"})
     * @param Task $task
     * @return View
     */
    public function deleteTask(Task $task): View
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

        return View::create($task, Response::HTTP_NO_CONTENT);
    }

    /**
     * Export to csv all tasks.
     *
     * @Rest\Get("/exportcsv", name="api_task_export_csv")
     */
    public function taskExportCSV(TaskRepository $taskRepository, Request $request): BinaryFileResponse
    {

        $user = $this->getUser();
        $tasks = $user->getTask();
        $summ = 0;
        $file_name = time() . '-' . 'export.csv';
        $file = fopen($file_name, 'w');

        foreach ($tasks as $task) {
            $summ = $summ + $task->getTimeSpend();
                $task_info = [
                    'title'               => $task->getTitle(),
                    'comment'             => $task->getComment(),
                    'date'                => ($task->getDate())->format('Y-m-d'),
                    'time_spend'          => $task->getTimeSpend(),
                ];
                fputcsv($file, $task_info);
        }
        fputcsv($file, ['title'=> null, 'comment'=> null, 'date'=> null, 'time_spend' => $summ]);

        fclose($file);

        return new BinaryFileResponse($file_name);
    }
}