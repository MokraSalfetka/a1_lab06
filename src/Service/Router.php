<?php
namespace App\Service;

class Router
{
    private array $routes = [];

    public function add(string $name, string $path, array $action): void
    {
        $this->routes[$name] = ['path' => $path, 'action' => $action];
    }

    public function match(string $uri): ?array
    {
        foreach ($this->routes as $route) {
            $pattern = preg_replace('#\{[a-z]+\}#', '([a-zA-Z0-9_-]+)', $route['path']);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);
                return ['action' => $route['action'], 'params' => $matches];
            }
        }
        return null;
    }

    public function generatePath(string $action, ?array $params = []): string
    {
        $query = $action ? http_build_query(array_merge(['action' => $action], $params)) : null;
        $path = "/index.php" . ($query ? "?$query" : null);
        return $path;
    }

    public function redirect(string $path): void
    {
        header("Location: $path");
        exit;
    }
}
