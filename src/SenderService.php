<?php

namespace Gladdle\NexahSms;

use Gladdle\NexahSms\Exception\AuthException;
use Gladdle\NexahSms\Exception\SendingFailureException;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SenderService
{
    private HttpClientInterface $httpClient;
    private ConfigInterface $config;
    private LoggerInterface $logger;
    private array $nums_error = [];

    public function __construct(
        HttpClientInterface $httpClient,
        ConfigInterface $config,
        LoggerInterface $logger
    ) {
        $this->httpClient = $httpClient;
        $this->config = $config;
        $this->logger = $logger;
    }

    public function send(String $number, string $message, \DateTime $scheduletime = null): bool
    {
        $this->logger->info("Calling Nexah API...");
        $payload = [
            "user" => $this->config->getUsername(),
            "password" => $this->config->getPassword(),
            "senderid" => $this->config->getSenderId(),
            "sms" => $message,
            "mobiles" => $number,
        ];

        if (null !== $scheduletime) {
            $payload['scheduletime'] = $scheduletime->format("YYYY-MM-dd HH:mm:ss");
        }

        $response = $this->httpClient->request(
            'POST',
            $this->config->getUrl(),
            [
                'json' => $payload,
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
            ]
        );
        $response_content = $response->toArray(false);

        $this->throwAuthErrorIfNeeded($response_content);
        $this->throwSmsErrorIfNeeded($response_content);
        
        $this->logger->info("Sending SMS");
        return true;
    }

    private function throwAuthErrorIfNeeded(array $response_content): void
    {
        if ($response_content['responsecode'] == 0) {
            $this->logger->error('Nexah SMS API call: {msg}', ['msg' => $response_content['responsemessage']]);
            throw new AuthException($response_content['responsemessage']);
        }
    }

    private function throwSmsErrorIfNeeded(array $response_content): void
    {
        /** @var array */
        $sms = $response_content['sms'];
        $sms_errors = array_filter($sms, function(array $item){
            if($item['status'] == "error"){
                return $item['mobileno'];
            }
        });

        if(sizeof($sms_errors) > 0){
            $this->nums_error = $sms_errors;
            $this->logger->error('Failure to send messages to certain numbers');
            throw new SendingFailureException("Failure to send messages to certain numbers");
        }
    }

    public function getNumsError(): array
    {
        return $this->nums_error;
    }

}
