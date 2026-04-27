<?php

namespace LargeFixture\Services;

class UnusedWarningService
{
    private $label;

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function calculate($left, $right)
    {
        $sum = $left + $right;
        $unused = 'intentional warning';

        return $sum;
    }
}
