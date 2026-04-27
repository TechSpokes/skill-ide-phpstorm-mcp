<?php

namespace LargeFixture\Contracts;

interface TaskHandler
{
    public function process($payload);
}
