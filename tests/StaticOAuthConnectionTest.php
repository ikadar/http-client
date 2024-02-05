<?php

namespace IKadar\HTTPClient\Connection;

use PHPUnit\Framework\TestCase;

class StaticOAuthConnectionTest extends TestCase
{
    private $staticOAuthConnection;

    protected function setUp(): void
    {
        // Initialize StaticOAuthConnection with example data
        $this->staticOAuthConnection = new StaticOAuthConnection(
            'https://api.example.com',
            'v1',
            'client_id_example',
            'secret_example'
        );
    }

    public function test__construct()
    {
        $this->assertInstanceOf(StaticOAuthConnection::class, $this->staticOAuthConnection);
    }

    public function testPrepareHeaders()
    {
        $headers = $this->staticOAuthConnection->prepareHeaders();
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('ClientID', $headers);
        $this->assertEquals('client_id_example', $headers['ClientID']);
        $this->assertArrayHasKey('Secret', $headers);
        $this->assertEquals('secret_example', $headers['Secret']);
    }

    public function testGetSecret()
    {
        $secret = $this->staticOAuthConnection->getSecret();
        $this->assertEquals('secret_example', $secret);
    }

    public function testGetClientId()
    {
        $clientId = $this->staticOAuthConnection->getClientId();
        $this->assertEquals('client_id_example', $clientId);
    }
}

