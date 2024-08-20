<?php

namespace Alves\Pix\Contracts\KeyValidations;

interface ValidateCnpjKey
{
    public static function validateCnpj(string $cnpj): bool;
}
