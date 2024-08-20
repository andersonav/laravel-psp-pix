<?php

namespace Alves\Pix\Tests\Api\Filters;

use Alves\Pix\Api\Filters\WebhookFilters;
use Alves\Pix\Tests\TestCase;

class WebhookFiltersTest extends TestCase
{
    public function test_it_return_filters_in_the_correct_format()
    {
        $expected = [
            'inicio'                   => $start = now()->subMonth()->toISOString(),
            'fim'                      => $end = now()->subMonth()->toISOString(),
            'paginacao.itensPorPagina' => 2,
            'paginacao.paginaAtual'    => 1,
        ];

        $filters = (new WebhookFilters())
            ->startingAt($start)
            ->currentPage(1)
            ->itemsPerPage(2)
            ->endingAt($end);

        $this->assertEquals($expected, $filters->toArray());
    }
}
