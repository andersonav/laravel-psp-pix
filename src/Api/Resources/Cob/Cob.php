<?php

namespace Alves\Pix\Api\Resources\Cob;

use Illuminate\Http\Client\Response;
use Alves\Pix\Api\Api;
use Alves\Pix\Api\Contracts\ApplyApiFilters;
use Alves\Pix\Api\Contracts\ConsumesCobEndpoints;
use Alves\Pix\Api\Contracts\FilterApiRequests;
use Alves\Pix\Exceptions\ValidationException;
use Alves\Pix\Support\Endpoints;
use RuntimeException;

class Cob extends Api implements ConsumesCobEndpoints, FilterApiRequests
{
    private array $filters = [];

    public function withFilters($filters): Cob
    {
        if (!is_array($filters) && !$filters instanceof ApplyApiFilters) {
            throw new RuntimeException("Filters should be an instance of 'FilterApiRequests' or an array.");
        }

        $this->filters = $filters instanceof ApplyApiFilters
                ? $filters->toArray()
                : $filters;

        return $this;
    }

    public function create(string $transactionId, array $request): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::CREATE_COB).$transactionId);

        return $this->request()->put($endpoint, $request);
    }

    public function createWithoutTransactionId(array $request): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::CREATE_COB));

        return $this->request()->post($endpoint, $request);
    }

    public function getByTransactionId(string $transactionId): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::GET_COB).$transactionId);

        return $this->request()->get($endpoint);
    }

    public function updateByTransactionId(string $transactionId, array $request): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::UPDATE_COB).$transactionId);

        return $this->request()->patch($endpoint, $request);
    }

    /**
     * @throws \Throwable
     */
    public function all(): Response
    {
        throw_if(
            empty($this->filters),
            ValidationException::filtersAreRequired()
        );

        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::GET_ALL_COBS));

        return $this->request()->get($endpoint, $this->filters);
    }
}
