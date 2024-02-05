<?php

namespace IKadar\HTTPClient\Connection;

use PHPUnit\Framework\TestCase;

// Concrete subclass of Connection for testing
class TestableConnection extends Connection
{
    public function prepareHeaders(): array
    {
        // Implement with minimal logic for testing
        return ['Content-Type' => 'application/json'];
    }
}

class ConnectionTest extends TestCase
{
    private $connection;

    protected function setUp(): void
    {
        // Initialize TestableConnection with example data
        $this->connection = new TestableConnection('https://api.example.com', 'v1');
    }

    public function testPrepareHeaders()
    {
        $headers = $this->connection->prepareHeaders();
        $this->assertIsArray($headers);
        $this->assertArrayHasKey('Content-Type', $headers);
        $this->assertEquals('application/json', $headers['Content-Type']);
    }

    public function test__construct()
    {
        $this->assertInstanceOf(TestableConnection::class, $this->connection);
    }

    public function testGetAPIVersion()
    {
        $apiVersion = $this->connection->getAPIVersion();
        $this->assertEquals('v1', $apiVersion);
    }

    public function testGetAPIRootUrl()
    {
        $apiRootUrl = $this->connection->getAPIRootUrl();
        $this->assertEquals('https://api.example.com', $apiRootUrl);
    }

    public function testPrepareUrl()
    {
        $endpoint = 'test/endpoint';
        $expectedUrl = 'https://api.example.com/v1/test/endpoint';
        $actualUrl = $this->connection->prepareUrl($endpoint);
        $this->assertEquals($expectedUrl, $actualUrl);
    }
}
