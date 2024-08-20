<?php

namespace Alves\Pix\Api\Contracts;

interface ConsumesPixApi
{
    public function getOauth2Token(string $scopes = null);
}
