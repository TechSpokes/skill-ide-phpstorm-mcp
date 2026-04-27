<?php

namespace LargeFixture\Handlers;

use LargeFixture\Contracts\TaskHandler;

class EmailTaskHandler extends AbstractHandler implements TaskHandler
{
    public function process($payload)
    {
        $normalized = $this->normalize($payload);
        return $this->logActivity('email:' . (isset($normalized['subject']) ? $normalized['subject'] : 'No subject'));
    }
}
