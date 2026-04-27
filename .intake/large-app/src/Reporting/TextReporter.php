<?php

namespace LargeFixture\Reporting;

use LargeFixture\Contracts\Reporter;

class TextReporter implements Reporter
{
    public function report(array $items)
    {
        $lines = array();
        foreach ($items as $item) {
            $lines[] = (string) $item;
        }

        return implode(PHP_EOL, $lines);
    }
}
