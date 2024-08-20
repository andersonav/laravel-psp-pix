<?php

namespace Alves\Pix\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Alves\Pix\Api\Api;
use Alves\Pix\Api\Auth;
use Alves\Pix\Api\Resources\Cob\Cob;
use Alves\Pix\Api\Resources\Cobv\Cobv;
use Alves\Pix\Api\Resources\PayloadLocation\PayloadLocation;
use Alves\Pix\Api\Resources\ReceivedPix\ReceivedPix;
use Alves\Pix\Api\Resources\Webhook\Webhook;
use Alves\Pix\Facades\ApiFacade;
use Alves\Pix\Facades\CobFacade;
use Alves\Pix\Facades\CobvFacade;
use Alves\Pix\Facades\PayloadLocationFacade;
use Alves\Pix\Facades\ReceivedPixFacade;
use Alves\Pix\Facades\WebhookFacade;
use Alves\Pix\LaravelPix;
use Alves\Pix\QrCodeGenerator;

class PixServiceProvider extends ServiceProvider
{
    public static bool $verifySslCertificate = false;

    public function boot()
    {
        $this->registerRoutes();

        $this->registerViews();

        $this->publishFiles();

        $this->bootBladeDirectives();
    }

    public function register()
    {
        LaravelPix::generatesQrCodeUsing(QrCodeGenerator::class);
        LaravelPix::authenticatesUsing(Auth::class);

        LaravelPix::useAsDefaultPsp('default');

        $this->registerFacades();
    }

    private function publishFiles(): void
    {
        $this->publishes([
            __DIR__.'/../../config/laravel-psp-pix.php' => config_path('laravel-psp-pix.php'),
        ], 'laravel-psp-pix-config');

        $this->publishes([
            __DIR__.'/../../public' => public_path('vendor/laravel-psp-pix'),
        ], 'laravel-psp-pix-assets');
    }

    private function bootBladeDirectives(): void
    {
        Blade::directive('laravelPixAssets', function () {
            $path = asset('vendor/laravel-psp-pix/css/app.css');

            return "<link rel='stylesheet' href='{$path}'>";
        });
    }

    private function registerRoutes(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../../routes/laravel-psp-pix-routes.php');
    }

    private function registerViews(): void
    {
        $this->loadViewsFrom(__DIR__.'/../../resources/views', 'laravel-psp-pix');
    }

    private function registerFacades(): void
    {
        $this->app->bind(ApiFacade::class, Api::class);
        $this->app->bind(CobFacade::class, Cob::class);
        $this->app->bind(CobvFacade::class, Cobv::class);
        $this->app->bind(WebhookFacade::class, Webhook::class);
        $this->app->bind(PayloadLocationFacade::class, PayloadLocation::class);
        $this->app->bind(ReceivedPixFacade::class, ReceivedPix::class);
    }
}
