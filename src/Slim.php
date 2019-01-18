<?php

namespace Omega\Engines;

use Omega\Core\EngineInterface;
use Omega\Core\RouteInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\App;

class Slim implements EngineInterface
{
    private $app;

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param array $routes
     * @return RouteInterface[]|void
     */
    public function addRoutes(array $routes) : void
    {
        array_map(function (RouteInterface $route) {
            $routeMethod = $route->getMethod();
            $methods = is_array($routeMethod) ? $routeMethod : [$routeMethod];
            $this->app->map($methods, $route->getPath(), $route->getController());
        }, $routes);
    }

    public function run(ServerRequestInterface $request) : void
    {
        $this->app->run($request);
    }
}
