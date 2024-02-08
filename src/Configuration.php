<?php

namespace Gladdle\NexahSms;

class Configuration implements ConfigInterface
{
    private string $url;
    private string $username;
    private string $password;
    private string $senderId;
    private ?string $logfile;

    public function __construct(
        string $username,
        string $password,
        string $senderId,
        string $logfile = null,
        string $url = 'https://smsvas.com/bulk/public/index.php/api/v1/sendsms'
    ) {
        $this->url = $url;
        $this->username = $username;
        $this->password = $password;
        $this->logfile = $logfile;
        $this->senderId = $senderId;
        
    }
    /**
     * Get the Nexah url endpoint
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * User login
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * User password
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * Sender ID
     */
    public function getSenderId(): string
    {
        return $this->senderId;
    }

    /**
     * Log file
     */
    public function getLogFile(): ?string
    {
        return $this->logfile;
    }
}
