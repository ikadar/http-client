<?php

namespace IKadar\HTTPClient\Connection;

abstract class Connection implements ConnectionInterface
{
    public function __construct(
        private readonly string $APIRootUrl,
        private readonly string $APIVersion,
    )
    {
    }

    /**
     * @return string
     */
    public function getAPIRootUrl(): string
    {
        return $this->APIRootUrl;
    }

    /**
     * @return string
     */
    public function getAPIVersion(): string
    {
        return $this->APIVersion;
    }

    public function prepareUrl($endpointUrl): string
    {
        return implode(separator: "/", array: [
            $this->getAPIRootUrl(),
            $this->getAPIVersion(),
            $endpointUrl
        ]);
    }

    abstract public function prepareHeaders(): array;

}
