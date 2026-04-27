<?php

namespace FocusLedger;

class TaskService
{
    private $repository;

    public function __construct(TaskRepository $repository)
    {
        $this->repository = $repository;
    }

    public function listActiveTasks()
    {
        $open = array();
        foreach ($this->repository->all() as $task) {
            if (!$task->isDone()) {
                $open[] = $task;
            }
        }

        return $open;
    }

    public function countCompletedTasks()
    {
        $completed = 0;
        foreach ($this->repository->all() as $task) {
            if ($task->isDone()) {
                $completed++;
            }
        }

        return $completed;
    }

    public function addTask($title, $priority)
    {
        $task = new Task($this->repository->nextId(), $title, $priority, false);
        $this->repository->save($task);

        return $task;
    }
}
