<?php

namespace Alves\Pix\Contracts;

interface GeneratesQrCode
{
    public function withPayload(PixPayloadContract $payload);
}
