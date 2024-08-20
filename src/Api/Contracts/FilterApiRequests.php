<?php

namespace Alves\Pix\Api\Contracts;

interface FilterApiRequests
{
    public function withFilters($filters): self;
}
