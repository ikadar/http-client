<?php

namespace IKadar\HTTPClient\Request;

use Symfony\Component\Yaml\Yaml;

trait RouteLoaderTrait
{
    private array $routes;

    public function loadRoutes($file): void
    {
        $filename = realpath ($file);
        $this->routes = Yaml::parseFile($filename);

        foreach ($this->routes as $name => $data) {
            $this->routes[$name] = new Route(
                path: $data["path"],
                requirements: $data["requirements"],
                methods: [$data["method"]],
                queryParameters: $data["queryParameters"]
            );
        }
    }

    public function route($name): Route
    {
        return $this->routes[$name];
    }


}
