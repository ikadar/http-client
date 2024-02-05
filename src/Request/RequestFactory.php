<?php

namespace IKadar\HTTPClient\Request;

use Exception;

class RequestFactory
{
    use RouteLoaderTrait;

    protected string $verb;

    public function __construct(
    )
    {
    }

    /**
     * @throws Exception
     */
    public function createRequest(
        string $routeName,
        array $parameters = [],
        array $options = []
    ): RequestInterface
    {
        $route = $this->route($routeName);
        $verb = strtoupper($route->getMethods()[0]);

        return match ($verb) {
            "GET" => new GetRequest($route, $parameters, $options),
            "POST" => new PostRequest($route, $parameters, $options),
            default => throw new Exception(sprintf("Unsupported verb [%s]", $verb)),
        };
    }

}
