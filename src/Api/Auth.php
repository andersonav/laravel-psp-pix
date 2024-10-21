<?php

namespace Alves\Pix\Api;

use Illuminate\Support\Facades\Http;
use Alves\Pix\Api\Contracts\AuthenticatesPSPs;
use Alves\Pix\Providers\PixServiceProvider;

class Auth implements AuthenticatesPSPs
{
    protected string $clientId;
    protected string $clientSecret;
    protected string $certificate;
    protected string $certificateKey;
    protected string $currentPspOauthEndpoint;
    protected ?string $certificatePassword;

    public function __construct(
        string $clientId,
        string $clientSecret,
        string $certificate,
        string $certificateKey,
        string $currentPspOauthEndpoint,
        ?string $certificatePassword
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->certificate = $certificate;
        $this->certificateKey = $certificateKey;
        $this->currentPspOauthEndpoint = $currentPspOauthEndpoint;
        $this->certificatePassword = $certificatePassword;
    }

    public function getToken(string $scopes = null)
    {
        $client = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => 'Basic '.base64_encode("{$this->clientId}:{$this->clientSecret}"),
        ])->withOptions([
            'auth' => [$this->clientId, $this->clientSecret],
        ]);

        if ($this->shouldVerifySslCertificate()) {
            $client->withOptions([
                'verify' => true,
                'cert'   => $this->getCertificate(),
                'ssl_key'=> $this->getCertificateKey()
            ]);
        }else{
            $client->withOptions([
                'verify' => false,
                'cert'   => $this->getCertificate(),
                'ssl_key'=> $this->getCertificateKey()
            ]);
        }

        return $client->post($this->getOauthEndpoint(), [
            'grant_type' => 'client_credentials',
            'scope'      => $scopes ?? '',
        ]);
    }

    protected function getCertificate()
    {
        return $this->certificatePassword ?? false
                ? [$this->certificate, $this->certificatePassword]
                : $this->certificate;
    }

    protected function getCertificateKey()
    {
        return $this->certificatePassword ?? false
                ? [$this->certificateKey, $this->certificatePassword]
                : $this->certificateKey;
    }

    private function shouldVerifySslCertificate(): bool
    {
        return PixServiceProvider::$verifySslCertificate;
    }

    public function getOauthEndpoint(): string
    {
        return $this->currentPspOauthEndpoint;
    }
}
