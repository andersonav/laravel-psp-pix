<?php

namespace Alves\Pix\Tests;

use Alves\Pix\Api\Api;
use Alves\Pix\Api\Resources\Cob\Cob;
use Alves\Pix\Api\Resources\Cobv\Cobv;
use Alves\Pix\Api\Resources\LoteCobv\LoteCobv;
use Alves\Pix\Api\Resources\PayloadLocation\PayloadLocation;
use Alves\Pix\Api\Resources\ReceivedPix\ReceivedPix;
use Alves\Pix\Api\Resources\Webhook\Webhook;
use Alves\Pix\Pix;

class PixTest extends TestCase
{
    public function test_cob_returns_a_cob_feature_instance()
    {
        $this->assertInstanceOf(Cob::class, Pix::cob());
    }

    public function test_cobv_returns_a_cobv_feature_instance()
    {
        $this->assertInstanceOf(Cobv::class, Pix::cobv());
    }

    public function test_webhook_returns_a_webhook_feature_instance()
    {
        $this->assertInstanceOf(Webhook::class, Pix::webhook());
    }

    public function test_payload_location_returns_a_payload_location_feature_instance()
    {
        $this->assertInstanceOf(PayloadLocation::class, Pix::payloadLocation());
    }

    public function test_api_returns_a_api_instance()
    {
        $this->assertInstanceOf(Api::class, Pix::api());
    }

    public function test_lote_cobv_returns_a_lote_cobv_feature_instance()
    {
        $this->assertInstanceOf(LoteCobv::class, Pix::loteCobv());
    }

    public function test_received_pix_returns_a_received_pix_feature_instance()
    {
        $this->assertInstanceOf(ReceivedPix::class, Pix::receivedPix());
    }
}
