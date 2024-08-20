<?php

namespace Alves\Pix\Tests;

use Alves\Pix\Providers\PixServiceProvider;
use Alves\Pix\Support\Endpoints;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    public string $cpfKey = '352.867.680-91';
    public string $randomKey = '8e85a8e2-f8ba-4f4e-bc95-e9e23e73b92f';
    public string $cnpjKey = '32.451.997/0001-92';
    public string $phoneNumberKey = '+5585981351151';
    public string $emailKey = 'andersonalves.dev@gmail.com';
    public string $dummyPspUrl = 'https://pix.dummy-psp.com/v2/*';

    public function setUp(): void
    {
        parent::setUp();
        (new PixServiceProvider($this->app))->boot();
    }

    public function getPackageProviders($app)
    {
        return [
            PixServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('laravel-psp-pix.country_phone_prefix', '+55');
        $app['config']->set('laravel-psp-pix.transaction_currency_code', 986);
        $app['config']->set('laravel-psp-pix.country_code', 'BR');
        $app['config']->set('laravel-psp-pix.gui', 'br.gov.bcb.pix');
        $app['config']->set('laravel-psp-pix.psp.default.base_url', 'https://pix.example.com/v2');
        $app['config']->set('laravel-psp-pix.psp.default.oauth_token_url', 'https://pix.example.com/oauth/token');
        $app['config']->set('laravel-psp-pix.psp.default.authentication_class', \Alves\Pix\Api\Contracts\AuthenticatesPSPs::class);
        $app['config']->set('laravel-psp-pix.psp.default.resolve_endpoints_using', Endpoints::class);
        $app['config']->set('laravel-psp-pix.psp.dummy-psp.base_url', 'https://pix.dummy-psp.com/v2');
        $app['config']->set('laravel-psp-pix.psp.dummy-psp.oauth_token_url', 'https://pix.dummy-psp.com/oauth/token');
        $app['config']->set('laravel-psp-pix.psp.dummy-psp.resolve_endpoints_using', EndpointsResolver::class);
    }
}
