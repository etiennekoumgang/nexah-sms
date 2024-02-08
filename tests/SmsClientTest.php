<?php

use Gladdle\NexahSms\Configuration;
use Gladdle\NexahSms\Exception\AuthException;
use Gladdle\NexahSms\Exception\SendingFailureException;
use Gladdle\NexahSms\SmsClient;
use PHPUnit\Framework\TestCase;

class SmsClientTest extends TestCase
{

    protected $fichierLog = __DIR__ . '/logs.log';

    /**
     * An exception must be raised when the user enters an incorrect username or password.
     */
    public function testAuthException()
    {
        $this->expectException(AuthException::class);

        $client = new SmsClient(
            new Configuration(
                getenv('NX_BAD_USER'),
                getenv('NX_PWD'),
                getenv('NX_SENDERID'),
            )
        );
        $client->send(getenv('NX_GOOD_NUM'), 'Hello World');
    }

    /**
     * An exception will be thrown if the user enters an incorrect number.
     */
    public function testSendingFaillureException()
    {
        $this->expectException(SendingFailureException::class);

        $client = new SmsClient(
            new Configuration(
                getenv('NX_GOOD_USER'),
                getenv('NX_PWD'),
                getenv('NX_SENDERID'),
            )
        );
        $client->send(getenv('NX_BAD_NUM'), 'Hello World');
    }

     /**
     * The log file must be generated if defined
     */
    public function testGeneratedLogFile()
    {
        $this->expectException(SendingFailureException::class);

        $client = new SmsClient(
            new Configuration(
                getenv('NX_GOOD_USER'),
                getenv('NX_PWD'),
                getenv('NX_SENDERID'),
                $this->fichierLog
            )
        );
        $client->send(getenv('NX_BAD_NUM'), 'Hello World');
        $this->assertFileExists($this->fichierLog);
        
    }

    protected function tearDown(): void {
        // Supprime le fichier à la fin du test
        if (file_exists($this->fichierLog)) {
            unlink($this->fichierLog);
        }

        parent::tearDown();
    }

    /**
     * Successful delivery
     */
    public function testSuccessfullDelivery()
    {
        
        $client = new SmsClient(
            new Configuration(
                getenv('NX_GOOD_USER'),
                getenv('NX_PWD'),
                getenv('NX_SENDERID'),
            )
        );
        $response = $client->send(getenv('NX_GOOD_NUM'), 'Hello World');

        $this->assertTrue($response);
    }
}
