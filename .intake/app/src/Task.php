<?php

namespace FocusLedger;

class Task
{
    private $id;
    private $title;
    private $priority;
    private $done;

    public function __construct($id, $title, $priority, $done)
    {
        $this->id = (int) $id;
        $this->title = (string) $title;
        $this->priority = (string) $priority;
        $this->done = (bool) $done;
    }

    public static function fromArray(array $row)
    {
        return new self($row['id'], $row['title'], $row['priority'], $row['done']);
    }

    public function toArray()
    {
        return array(
            'id' => $this->id,
            'title' => $this->title,
            'priority' => $this->priority,
            'done' => $this->done,
        );
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getPriority()
    {
        return $this->priority;
    }

    public function isDone()
    {
        return $this->done;
    }
}
