<?php

namespace IKadar\HTTPClient\Connection;

class StaticOAuthConnection extends Connection implements ConnectionInterface
{

    public function __construct(
        private readonly string $APIRootUrl,
        private readonly string $APIVersion,
        private readonly string $clientId,
        private readonly string $secret
    )
    {
        parent::__construct(
            $this->APIRootUrl,
            $this->APIVersion
        );
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }

    public function prepareHeaders(): array
    {
        return [
            "ClientID" => $this->getClientId(),
            "Secret" => $this->getSecret()
        ];
    }

}
