<?php

namespace Alves\Pix\Contracts\KeyValidations;

interface ValidatePhoneNumberKeys
{
    public static function validatePhoneNumber(string $phone): bool;
}
