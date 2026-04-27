<?php

namespace FocusLedger;

class TaskRepository
{
    private $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function all()
    {
        if (!file_exists($this->filePath)) {
            return array();
        }

        $raw = file_get_contents($this->filePath);
        $rows = json_decode($raw, true);
        if (!is_array($rows)) {
            return array();
        }

        $tasks = array();
        foreach ($rows as $row) {
            $tasks[] = Task::fromArray($row);
        }

        return $tasks;
    }

    public function save(Task $task)
    {
        $rows = array();
        foreach ($this->all() as $existing) {
            $rows[] = $existing->toArray();
        }

        $rows[] = $task->toArray();
        file_put_contents($this->filePath, json_encode($rows, JSON_PRETTY_PRINT));
    }

    public function nextId()
    {
        $max = 0;
        foreach ($this->all() as $task) {
            $max = max($max, $task->getId());
        }

        return $max + 1;
    }
}
