<?php

namespace LargeFixture\Handlers;

use LargeFixture\Contracts\TaskHandler;

class WebhookTaskHandler extends AbstractHandler implements TaskHandler
{
    public function process($payload)
    {
        $normalized = $this->normalize($payload);
        $url = isset($normalized['url']) ? $normalized['url'] : 'http://localhost';

        return $this->logActivity('webhook:' . $url);
    }
}
