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

class Client implements ClientInterface
{
    private HttpClientInterface $client;

    private static int $maxHostConnections = 6;
    private static int $maxPendingPushes = 50;

    public function __construct(
        private readonly ConnectionInterface $connection
    )
    {
        $defaultOptions = [
            "headers" => []
        ];

        $defaultOptions["headers"] = array_merge(
            $defaultOptions["headers"],
            $this->getConnection()->prepareHeaders()
        );

        $this->client = HttpClient::create(
            $defaultOptions,
            self::$maxHostConnections,
            self::$maxPendingPushes
        );
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection(): ConnectionInterface
    {
        return $this->connection;
    }

    /**
     * @return HttpClientInterface
     */
    public function getClient(): HttpClientInterface
    {
        return $this->client;
    }

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
    ): ?array
    {

        try {
            list($method, $endPointUrl, $options) = $request->fetch();
            $url = $this->getConnection()->prepareUrl($endPointUrl);
            $response = $this->getClient()->request(method: $method, url: $url, options: $options);
        } catch (
        TransportExceptionInterface|
        ServerExceptionInterface|
        RedirectionExceptionInterface|
        ClientExceptionInterface
        $e
        ) {
            // todo add exception handling
            //
            dump($e);
            return null;
        } catch (Exception $e) {
            // todo handle exception
            dump($e);
            return null;
        }


        // Get the status code
        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            // todo log / notify
            throw new Exception(message: "HTTP response status was " . $statusCode);
        }

        // todo handle status codes

        // Get the content of the response
        $content = $response->getContent();

//        dump($method);
//        dump($url);
//        dump($options);
//        dump(json_decode($content, true));

        return json_decode(json: $content, associative: true);
    }
}
