<?php

namespace IKadar\HTTPClient\Client;

use IKadar\HTTPClient\Connection\ConnectionInterface;
use IKadar\HTTPClient\Request\RequestInterface;
use PHPUnit\Framework\TestCase;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class ClientTest extends TestCase
{
    private $client;
    private $connectionMock;
    private $httpClientMock;

    protected function setUp(): void
    {
        // Mock the ConnectionInterface
        $this->connectionMock = $this->createMock(ConnectionInterface::class);
        $this->connectionMock->expects($this->any())
            ->method('prepareHeaders')
            ->willReturn(['Authorization' => 'Bearer token']);
        $this->connectionMock->expects($this->any())
            ->method('prepareUrl')
            ->willReturn('https://api.example.com/v1/test');

        // Initialize the client with the mocked connection
        $this->client = new Client($this->connectionMock);
    }

    public function testGetClient()
    {
        $httpClient = $this->client->getClient();
        $this->assertInstanceOf(HttpClientInterface::class, $httpClient);
    }

    public function testGetConnection()
    {
        $connection = $this->client->getConnection();
        $this->assertSame($this->connectionMock, $connection);
    }

    public function testSendRequest()
    {
        // Mock the RequestInterface
        $requestMock = $this->createMock(RequestInterface::class);
        $requestMock->expects($this->any())
            ->method('fetch')
            ->willReturn(['GET', 'test', []]);

        // Mock the ResponseInterface
        $responseMock = $this->createMock(ResponseInterface::class);
        $responseMock->expects($this->any())
            ->method('getStatusCode')
            ->willReturn(200);
        $responseMock->expects($this->any())
            ->method('getContent')
            ->willReturn(json_encode(['data' => 'value']));

        // Mock the HttpClientInterface to return the mocked response
        $httpClientMock = $this->createMock(HttpClientInterface::class);
        $httpClientMock->expects($this->any())
            ->method('request')
            ->willReturn($responseMock);

        // Inject the mocked HttpClient into the Client object
        $reflectionClass = new \ReflectionClass(Client::class);
        $reflectionProperty = $reflectionClass->getProperty('client');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($this->client, $httpClientMock);

        // Perform the test
        $response = $this->client->sendRequest($requestMock);
        $this->assertIsArray($response);
        $this->assertEquals(['data' => 'value'], $response);
    }

    public function test__construct()
    {
        $this->assertInstanceOf(Client::class, $this->client);
    }
}
