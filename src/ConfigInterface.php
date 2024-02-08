<?php

namespace Gladdle\NexahSms;

interface ConfigInterface
{
    /**
     * Get the Nexah url endpoint
     */
    public function getUrl(): string;

    /**
     * User login
     */
    public function getUsername(): string;

    /**
     * User password
     */
    public function getPassword(): string;

    /**
     * Sender ID
     */
    public function getSenderId(): string;

    /**
     * Get the Nexah url endpoint
     */
    public function getBalanceUrl(): string;
}