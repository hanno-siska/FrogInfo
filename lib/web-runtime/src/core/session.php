<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Core;

// Requires
use WebRuntime\Services\Debug;
use WebRuntime\Services\DebugLevel;

// Classes
final readonly class SessionCookieConfig {
    public function __construct(
        public int $lifetime = 0,
        public bool $http_only = true,
        public string $path = "/",
        public string $samesite = "Lax",
        public bool $secure = true
    ) {}

    public function to_array(): array {
        return [
            "lifetime" => $this->lifetime,
            "httponly" => $this->http_only,
            "path" => $this->path,
            "samesite" => $this->samesite,
            "secure" => $this->secure
        ];
    }
}

final class SessionManagement {
    private static ?SessionCookieConfig $session_config = NULL;

    public static function config(SessionCookieConfig $session_config): void {
        self::$session_config = $session_config;
        Debug::in(DebugLevel::INFO, "SessionManagement: Set user provided session cookie config to: ".json_encode(self::$session_config->to_array()));
    }

    public static function start(): void {
        if (session_status() !== PHP_SESSION_NONE) {return;}
        if (is_null(self::$session_config)) {
            self::$session_config = new SessionCookieConfig();
            Debug::in(DebugLevel::WARNING, "SessionManagement: SessionCookieConfig not set! using defaults: ".json_encode(self::$session_config->to_array()));
        }

        session_set_cookie_params(self::$session_config->to_array());
        session_start();

        Debug::in(DebugLevel::DEBUG, "SessionManagement: Created new/Continuing old session '".session_id()."'");
    }

    public static function remove(string $key): void {
        if (!key_exists($key, $_SESSION["data"] ?? [])) {return;}
        unset($_SESSION["data"][$key]);
    }

    public static function set(string $key, mixed $value): void {
        $_SESSION["data"][$key] = $value;
    }

    public static function get(string $key, mixed $default = NULL): mixed {
        if (!key_exists($key, $_SESSION["data"])) {return $default;}
        return $_SESSION["data"][$key];
    }

    public static function flash_set(string $key, mixed $value): void {
        $_SESSION["flash"][$key] = $value;
        Debug::in(DebugLevel::DEBUG, "SessionManagement: Flash set key '$key', value '$value'");
    }

    public static function flash_get(string $key, mixed $default = NULL): mixed {
        if (!key_exists($key, $_SESSION["flash"])) {
            Debug::in(DebugLevel::DEBUG, "SessionManagement: Flash get key '$key', not found, passing default value '$default'");
            Debug::in(DebugLevel::DEBUG, "SessionManagement: Orphaned data ".json_encode($_SESSION["flash"]));
            return $default;
        }

        $data = $_SESSION["flash"][$key];
        unset($_SESSION["flash"][$key]);

        Debug::in(DebugLevel::DEBUG, "SessionManagement: Flash get key '$key', got value '$data'");
        Debug::in(DebugLevel::DEBUG, "SessionManagement: Orphaned data ".json_encode($_SESSION["flash"]));
        return $data;
    }
}

?>