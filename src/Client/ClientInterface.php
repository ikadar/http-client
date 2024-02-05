<?php

namespace IKadar\HTTPClient\Client;

use Exception;
use IKadar\HTTPClient\Connection\ConnectionInterface;
use IKadar\HTTPClient\Request\RequestInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

interface ClientInterface
{

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface;

    /**
     * @return HttpClientInterface
     */
    public function getClient(): HttpClientInterface;

    /**
     * @param RequestInterface $request
     * @return array|null
     * @throws ClientExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws Exception
     */
    public function sendRequest(
        RequestInterface $request,
    ): ?array;
}
