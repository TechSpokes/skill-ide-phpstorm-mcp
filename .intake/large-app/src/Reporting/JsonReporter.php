<?php

namespace LargeFixture\Reporting;

use LargeFixture\Contracts\Reporter;

class JsonReporter implements Reporter
{
    public function report(array $items)
    {
        return json_encode($items, JSON_PRETTY_PRINT);
    }
}
