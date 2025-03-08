<?php

namespace App\Core;

use PDO;

class App
{
    private static $db = null;

    private $routesList = [];

    /**
     * Add route
     *
     * @param string $method GET/POST
     * @param string $url '/', for example
     * @param string $controllerClass SomeController::class, for example
     * @param string $methodName index, for example
     * @return $this
     * @throws \Exception
     */
    public function addRoute(string $method, string $url, string $controllerClass, string $methodName): App
    {
        if (!in_array($method, Request::METHODS)) {
            throw new \Exception('Bad method in routes: ' . $method);
        }

        $this->routesList[$method][$url] = [$controllerClass, $methodName];

        return $this;
    }

    public function connectDb(string $dbName): App
    {
        self::$db = (new Db())->getConnect($dbName);

        return $this;
    }

    public static function db(): ?PDO
    {
        return self::$db;
    }

    /**
     * Resolve current route
     *
     * @return bool|int
     */
    public function resolve()
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? null;

        $uri = $_SERVER['REQUEST_URI'] ?? null;
        if ($uri !== null) {
            $uri = parse_url($uri)['path'];
        }

        $foundedControllerInfo = $this->routesList[$method][$uri] ?? null;
        if ($foundedControllerInfo === null) {
            return http_response_code(404);
        }

        [$controllerClass, $methodName] = $foundedControllerInfo;

        /** @var Controller $currentController */
        $currentController = new $controllerClass();

        return $currentController->$methodName($_REQUEST);
    }
}
