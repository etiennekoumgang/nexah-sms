<?php

namespace Gladdle\NexahSms;

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Symfony\Component\HttpClient\HttpClient;

class SmsClient
{
    private SenderService $sender;

    private Configuration $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
        
        $logger = new Logger('SMS');
        if (null != $config->getLogFile()) {
            $logger->pushHandler(new StreamHandler($config->getLogFile()));
            $logger->pushHandler(new FirePHPHandler());
        }

        $this->sender = new SenderService(
            HttpClient::create(),
            $config,
            $logger
        );
    }

    public function send(string $number, string $message): bool
    {
        return $this->sender->send($number, $message);
    }

    public function getBalance(): string
    {
        return $this->sender->getBalance();
    }

    public function getConfig(): Configuration
    {
        return $this->config;
    }
}
