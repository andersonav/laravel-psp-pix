<?php

namespace Alves\Pix\Events\Webhooks;

class WebhookDeletedEvent
{
    public string $pixKey;

    public function __construct(string $pixKey)
    {
        $this->pixKey = $pixKey;
    }
}
