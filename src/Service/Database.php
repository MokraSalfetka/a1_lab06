<?php

namespace App\Service;

class Database
{
    private \PDO $pdo;

    public function __construct()
    {
        $this->pdo = new \PDO('sqlite:'. __DIR__. '/../data.db');
        $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    }

    public function query(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function execute(string $query, array $params = []): void
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
    }
}
