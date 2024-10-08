<?php

namespace Alves\Pix\Contracts;

interface CanResolveEndpoints
{
    public function setEndpoint(string $key, string $value): void;

    public function getEndpoint(string $key): string;
}
