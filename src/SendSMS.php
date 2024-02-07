<?php

namespace Gladdle\NexahSms;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class SendSMS
{
    private HttpClientInterface $httpClient;
    private ConfigInterface $config;

    public function __construct(
        HttpClientInterface $httpClient,
        ConfigInterface $config
    ) {
        $this->httpClient = $httpClient;
        $this->config = $config;
    }

    public function send(String $number, string $message): bool
    {

        return true;
    }
}
