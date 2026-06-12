<?php
// Config
declare(strict_types=1);
namespace App;

// Requires
use PDO;
use PDOException;
use WebRuntime\Core\Response;
use WebRuntime\Core\RouteDisplay;
use WebRuntime\WebRuntime;
use WebRuntime\WebRuntimeSession;

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

    public function get_popular_frog(bool $get_one = true): array {
        $stmt = $this->pdo->query("SELECT id, title, description, image_description, image, viewed_count FROM frog_articles ORDER BY viewed_count ASC LIMIT 4");
        if ($get_one) {return $stmt->fetch(PDO::FETCH_ASSOC);}
        else {return $stmt->fetchAll(PDO::FETCH_ASSOC);}
    }

    public function get_frog_count(): int {
        $stmt = $this->pdo->query("SELECT COUNT(*) FROM frog_articles");
        return (int) ($stmt->fetch(PDO::FETCH_COLUMN) ?? 0);
    }

    public function get_frogs_by_search(string $query): array {
        $stmt = $this->pdo->prepare("SELECT * FROM frog_articles WHERE title LIKE ?");
        $stmt->execute(["%$query%"]);
    }

    public function get_frog_by_id(int $id): array {}

    public function get_frogs(): array {
        $stmt = $this->pdo->query("SELECT * FROM frog_articles");
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
    }

    public function get_images(): array {
        try {
            $stmt = $this->pdo->query("SELECT id, image, image_description FROM frog_articles");
            return $stmt->fetchAll(PDO::FETCH_ASSOC) ?? [];
        } catch(PDOException $e) {
            WebRuntimeSession::flash_set("msg", "Error 500, Failed to load images, fatal database failure");
            $disp = new RouteDisplay();
            $disp->redirect(new Response(302, "/error"));
            return [];
        }
    }
}

?>