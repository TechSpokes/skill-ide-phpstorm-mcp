<?php

namespace LargeFixture\Services;

use LargeFixture\Contracts\TaskHandler;

class DispatchService
{
    private $handlers;

    public function __construct(array $handlers)
    {
        $this->handlers = $handlers;
    }

    public function dispatchAll($payload)
    {
        $results = array();
        foreach ($this->handlers as $handler) {
            if ($handler instanceof TaskHandler) {
                $results[] = $handler->process($payload);
            }
        }

        return $results;
    }
}
