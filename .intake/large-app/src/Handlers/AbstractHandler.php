<?php

namespace LargeFixture\Handlers;

use LargeFixture\Support\LogsActivity;

abstract class AbstractHandler
{
    use LogsActivity;

    protected function normalize($payload)
    {
        if (is_array($payload)) {
            return $payload;
        }

        return array('value' => $payload);
    }
}
