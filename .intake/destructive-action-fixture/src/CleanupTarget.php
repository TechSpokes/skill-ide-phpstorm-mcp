<?php

namespace DestructiveFixture;

class CleanupTarget
{
    private $label;

    public function __construct($label)
    {
        $this->label = $label;
    }

    public function calculate($left, $right)
    {
        $sum = $left + $right;
        $unused = 'cleanup';

        return $sum;
    }
}
