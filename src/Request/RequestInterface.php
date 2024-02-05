<?php

namespace IKadar\HTTPClient\Request;

use IKadar\HTTPClient\Request\Route;

interface RequestInterface
{
    /**
     * @return Route
     */
    public function getEndPointRoute(): Route;

    /**
     * @return array
     */
    public function getParameters(): array;

    /**
     * @return array
     */
    public function getOptions(): array;

    /**
     * @return string
     */
    public function getEndPointUrl(): string;

    public function fetch(): array;

}
