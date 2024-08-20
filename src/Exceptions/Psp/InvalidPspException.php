<?php

namespace Alves\Pix\Exceptions\Psp;

use Alves\Pix\Exceptions\PixException;

class InvalidPspException extends PixException
{
    public static function pspNotFound(string $psp): InvalidPspException
    {
        return new static("O psp `{$psp}` informado não foi configurado.");
    }
}
