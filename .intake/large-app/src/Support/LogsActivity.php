<?php

namespace LargeFixture\Support;

trait LogsActivity
{
    public function logActivity($message)
    {
        return '[' . date('c') . '] ' . $message;
    }
}
