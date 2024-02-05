<?php

namespace IKadar\HTTPClient\Request;

use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;

abstract class Request implements RequestInterface
{
    protected string $endPointUrl;
    protected array $payload;

    public function __construct(
        protected Route $endPointRoute,
        protected array $parameters,
        protected ?array $options = [],
    )
    {
        $this->splitParameters();
        $this->calculateEndpointUrl();
    }

    /**
     * @return Route
     */
    public function getEndPointRoute(): Route
    {
        return $this->endPointRoute;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getEndPointUrl(): string
    {
        return $this->endPointUrl;
    }

    /**
     * @return ?array
     */
    public function getQueryParameters(): ?array
    {
        return $this->getEndPointRoute()->getQueryParameters();
    }

    public function splitParameters()
    {
        $compiledRoute = $this->getEndPointRoute()->compile();
        $this->payload = array_diff_key(
            $this->getParameters(),
            array_merge(
                array_flip($compiledRoute->getVariables()),
                array_flip($this->getQueryParameters())
            )
        );

        $this->parameters = array_diff_key($this->getParameters(), $this->payload);
        if ($this->payload !== []) {
            $this->options["json"] = $this->payload;
        }

    }

    public function calculateEndpointUrl(): void
    {
        // Create a RouteCollection and add the route
        $routes = new RouteCollection();
        $routes->add('route', $this->getEndPointRoute());

        // Create RequestContext with information about the HTTP request
        $requestContext = new RequestContext('/');

        $urlGenerator = new UrlGenerator($routes, $requestContext);

        // Generate a URL for the 'route' route with an 'id' parameter
        try {
            $url = $urlGenerator->generate('route', $this->parameters);
        } catch (\Exception $e){
            dump($e);
            die();
        }

        $this->endPointUrl = trim($url, "/");
    }

    public function fetch(): array
    {
        return [static::verb, $this->getEndPointUrl(), $this->getOptions()];
    }

}
