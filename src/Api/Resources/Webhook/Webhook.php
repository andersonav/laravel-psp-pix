<?php

namespace Alves\Pix\Api\Resources\Webhook;

use Illuminate\Http\Client\Response;
use Alves\Pix\Api\Api;
use Alves\Pix\Api\Contracts\ApplyApiFilters;
use Alves\Pix\Api\Contracts\ConsumesWebhookEndpoints;
use Alves\Pix\Api\Contracts\FilterApiRequests;
use Alves\Pix\Events\Webhooks\WebhookCreatedEvent;
use Alves\Pix\Events\Webhooks\WebhookDeletedEvent;
use Alves\Pix\Support\Endpoints;
use RuntimeException;

class Webhook extends Api implements ConsumesWebhookEndpoints, FilterApiRequests
{
    private array $filters = [];

    public function withFilters($filters): Webhook
    {
        if (!is_array($filters) && !$filters instanceof ApplyApiFilters) {
            throw new RuntimeException("Filters should be an instance of 'FilterApiRequests' or an array.");
        }

        $this->filters = $filters instanceof ApplyApiFilters
            ? $filters->toArray()
            : $filters;

        return $this;
    }

    public function create(string $pixKey, string $callbackUrl): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::CREATE_WEBHOOK).$pixKey);

        $webhook = $this->request()->put($endpoint, ['webhookUrl' => $callbackUrl]);

        if(is_array($webhook)){
            event(new WebhookCreatedEvent($webhook->json()));
        }

        return $webhook;
    }

    public function getByPixKey(string $pixKey): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::GET_WEBHOOK).$pixKey);

        return $this->request()->get($endpoint);
    }

    public function delete(string $pixKey): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::DELETE_WEBHOOK).$pixKey);

        $webhook = $this->request()->delete($endpoint);

        event(new WebhookDeletedEvent($pixKey));

        return $webhook;
    }

    public function all(): Response
    {
        $endpoint = $this->getEndpoint($this->baseUrl.$this->resolveEndpoint(Endpoints::GET_WEBHOOKS));

        return $this->request()->get($endpoint, $this->filters);
    }
}
