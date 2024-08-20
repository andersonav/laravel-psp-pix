<?php

namespace Alves\Pix\Contracts\KeyValidations;

interface ValidateCPFKey
{
    public static function validateCPF(string $cpf): bool;
}
