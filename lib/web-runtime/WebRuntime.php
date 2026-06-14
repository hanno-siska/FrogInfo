<?php
// Config
declare(strict_types=1);
namespace WebRuntime;

// Requires
require_once __DIR__."/src/services/debugger.php";
require_once __DIR__."/src/utilities/utilities.php";
require_once __DIR__."/src/core/context.php";
require_once __DIR__."/src/core/action_handler.php";
require_once __DIR__."/src/core/router.php";
require_once __DIR__."/src/core/session.php";

use WebRuntime\Core\Request;
use WebRuntime\Core\RouteRegistry;
use WebRuntime\Core\RouteDisplay;
use WebRuntime\Core\Actions;
use WebRuntime\Core\SessionCookieConfig;
use WebRuntime\Core\SessionManagement;
use WebRuntime\Services\Debug;
use WebRuntime\Services\DebugLevel;

// Class
final class WebRuntimeSession {
    public static function config(SessionCookieConfig $session_config): void {
        SessionManagement::config($session_config);
    }

    public static function remove(string $key): void {
        SessionManagement::remove($key);
    }

    public static function set(string $key, mixed $value): void {
        SessionManagement::set($key, $value);
    }

    public static function get(string $key, mixed $default = NULL): mixed {
        return SessionManagement::get($key, $default);
    }

    public static function flash_set(string $key, mixed $value): void {
        SessionManagement::flash_set($key, $value);
    }

    public static function flash_get(string $key, mixed $default = NULL): mixed {
        return SessionManagement::flash_get($key, $default);
    }
}

final class WebRuntime {
    public const VERSION = "0.2.0";
    public function __construct(
        private string $base_url,
        private string $views_dir,
        private ?string $baseuri = NULL,
        private array $actions = [],
        private bool $debug_mode = false
    ) {}

    public function execute(): void {
        // Debug
        Debug::$active = $this->debug_mode;
        Debug::in(DebugLevel::INFO, "Starting request handling");

        // Setup
        SessionManagement::start();

        $registry = new RouteRegistry($this->views_dir, $this->base_url, $this->baseuri);
        $route_display = new RouteDisplay();

        $actions = new Actions($this->actions);

        // Runner
        $registry->scan();
        $request = new Request();

        $response_path = $registry->route($request);
        $response = $actions->execute($request, $response_path);

        $route_display->handle($response);
    }
}

?>