<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence;

class BaseRepository {
    /**
     * @var \PDO
     */
    protected $pdo;

    public function __construct( \PDO $pdo ) {
        $this->pdo = $pdo;
    }
}