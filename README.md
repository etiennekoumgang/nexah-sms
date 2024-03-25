# Nexah SMS API - PHP library
This PHP library lets you communicate with the Nexah API. You can send SMS messages and check your SMS balance. The library gives developers the flexibility to manage their interaction with the API.
To use the API, you need an account. Visit the official website https://nexah.net/ to get one.

## Requirements
- A username and password from https://nexah.net/
- PHP 7.4 and above
- Composer

## Installation
Via composer
```bash
$ composer require gladdle/nexah-sms
``` 

## Basic Usage
```php
<?php

require "./vendor/autoload.php";

use Gladdle\NexahSms\Configuration;
use Gladdle\NexahSms\SmsClient;

$client = new SmsClient(
    new Configuration(
        "username",
        "password",
        "senderId"
    )
);

// Multiple numbers
// formats: 6xxxxxxxx or 2376xxxxxxxx
$client->send("6xxxxxxxx, 2376xxxxxxxx", "Message to be sent"); // returns true

// One number
$client->send("6xxxxxxxx", "Message to be sent"); // returns true

// Get SMS balance
$client->getBalance() // returns number, eg 10000

```

## Catching errors

When you try to communicate with the API, errors may occur:
- Incorrect username and/or password,
- Invalid phone numbers

You can adapt your codes according to the error encountered

```php
use Gladdle\NexahSms\Exception\AuthException;
use Gladdle\NexahSms\Exception\SendingFailureException;

try {

    $client->send("6xxxxxxxx, 2376xxxxxxxx", "Message to be sent");
    $client->getBalance();

} catch (AuthException $e) {
    // Wrong username and/or password 
    // do stoff...
} catch (SendingFailureException $e) {
    // Incorrect numbers. Message not sent
    // Retrieve them
    $numbers = $client->getInvalidNumbers(); // ['6xxxxxxxxx', 'xxxxxxxxx'];
}

```

## Testing
Immediately after installation, you can test the library without writing a line of code. Make sure you have a valid username and password.

```bash
$ NX_BAD_USER=username NX_GOOD_USER=username NX_PWD=password NX_GOOD_NUM=677777777 NX_BAD_NUM=6777777771 NX_SENDERID=senderId  php vendor/bin/phpunit tests/
```
**NX_BAD_USER** and the others are environment variables. You can define them according to your operating system

- **NX_BAD_USER** invalid username 
- **NX_GOOD_USER** valid username 
- **NX_PWD** good password
- **NX_GOOD_NUM** good number
- **NX_BAD_NUM** invalid number like 10 digits

## Logs
You can stream logs messages by defining file path

```php
$client = new SmsClient(
    new Configuration(
        "username",
        "password",
        "senderId"
        __DIR__ . '/var/logs.log'
    )
);

```

### Author

Koumé KOUMGANG - <https://www.linkedin.com/in/etiennekoumgang/>

