<?php

namespace LargeFixture\Services;

use LargeFixture\Contracts\Reporter;

class ReportService
{
    private $reporter;

    public function __construct(Reporter $reporter)
    {
        $this->reporter = $reporter;
    }

    public function render(array $items)
    {
        $result = $this->reporter->report($items);

        return $result;
    }
}
