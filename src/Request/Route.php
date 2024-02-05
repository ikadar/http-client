<?php

namespace IKadar\HTTPClient\Request;

use Symfony\Component\Routing\Route as BaseClass;

class Route extends BaseClass
{
    public function __construct(
        string $path,
        array $defaults = [],
        array $requirements = [],
        array $options = [],
        ?string $host = '',
        array|string $schemes = [],
        array|string $methods = [],
        ?string $condition = '',
        private readonly ?array $queryParameters = []
    )
    {
        parent::__construct($path, $defaults, $requirements, $options, $host, $schemes, $methods, $condition);
    }

    /**
     * @return ?array
     */
    public function getQueryParameters(): ?array
    {
        return $this->queryParameters;
    }
}
