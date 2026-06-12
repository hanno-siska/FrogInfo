<?php
// Config
declare(strict_types=1);
namespace App;

// Requires
use PDO;

final class DataStore {
    private const DATABASE_LOCATION = __DIR__."/../../data/frogbase.db";
    private const DATABASE_SCHEMA = __DIR__."/../config/schema.sql";
    private PDO $pdo;

    public function __construct(){
        try {
            $this->pdo = new \PDO("sqlite:".self::DATABASE_LOCATION);
            $this->pdo->exec(file_get_contents(self::DATABASE_SCHEMA));
        } catch(\PDOException $e) {
            echo $e->getMessage();
            die(1);
        }
    }

    public function get_frog_count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM frog_articles");
        return $stmt->fetch(PDO::FETCH_COLUMN) ?? 0;
    }

    public function get_frogs_by_search(string $query): array {}

    public function get_frog_by_id(int $id): array {}

    public function get_frogs(): array {
        $stmt = $this->pdo->query("SELECT * FROM frog_articles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function get_images(): array {
        $stmt = $this->pdo->query("SELECT id, image FROM frog_articles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }
}

?>