<?php

namespace LargeFixture\Handlers;

use LargeFixture\Contracts\TaskHandler;

class SmsTaskHandler extends AbstractHandler implements TaskHandler
{
    public function process($payload)
    {
        $normalized = $this->normalize($payload);
        $number = isset($normalized['number']) ? $normalized['number'] : 'unknown';

        return $this->logActivity('sms:' . $number);
    }
}
