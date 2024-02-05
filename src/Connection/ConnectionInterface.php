<?php

namespace IKadar\HTTPClient\Connection;

interface ConnectionInterface
{
    public function prepareHeaders(): array;

    public function prepareUrl($endpointUrl): string;
}
