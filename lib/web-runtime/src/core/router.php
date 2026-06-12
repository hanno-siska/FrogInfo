<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Core;

// Requires
use WebRuntime\Utilities\PathUtils;
use WebRuntime\Core\Request;
use WebRuntime\Core\Response;
use WebRuntime\Services\Debug;
use WebRuntime\Services\DebugLevel;

// Classes
final class RouteRegistry {
    public array $views = [];

    public function __construct(
        private string $scan_dir,
        private string $baseurl
    ){}

    public function scan(string $carrypath = ""): void {
        $path = PathUtils::build($this->scan_dir, $carrypath);
        if (!file_exists($path) or !is_dir($path)) {return;}

        foreach (scandir($path) as $pathable) {
            if ($pathable === "." or $pathable === "..") {continue;}

            if (is_dir(PathUtils::build($path, $pathable))) {
                $this->scan(PathUtils::build($carrypath, $pathable));
                continue;
            }

            if (preg_match("/([A-Za-z0-9._-]+)(?:\.php|\.html)/", $pathable, $matches)) {
                if ($carrypath !== "") {
                    if (preg_match("/([A-Za-z0-9._-]+)\.prefix/", $carrypath, $prefix_match)) {
                        $name = PathUtils::build(preg_replace("/([A-Za-z0-9._-]+)\.prefix/", "", ltrim($carrypath, "/\\")), $matches[1]);
                        $prefix = $prefix_match[1];
                    } else {
                        $name = PathUtils::build($carrypath, $matches[1]);
                        $prefix = ".";
                    }
                } else {
                    $prefix = ".";
                    $name = PathUtils::build("", $matches[1]);
                }

                if (str_ends_with($name, "index")) {
                    $name = substr($name, 0, -5);
                }

                Debug::in(DebugLevel::DEBUG, "RouteRegistry registered: $prefix$name, filepath: ".PathUtils::build($path, $pathable));
                $this->views[$prefix][$name] = PathUtils::build($path, $pathable);
            }
        }
    }

    public function route(Request $request): ?string {
        if (strlen($request->host) === strlen($this->baseurl)) {$prefix = ".";}
        else {$prefix = explode(".", $request->host, 2)[0];}

        if (!key_exists($prefix, $this->views)) {Debug::in(DebugLevel::DEBUG, "RouteRegistry: prefix '$prefix', doesn't exist"); return NULL;}
        if (!key_exists($request->uri, $this->views[$prefix])) {Debug::in(DebugLevel::DEBUG, "RouteRegistry: request URI '$request->uri', not found in registered paths under prefix '$prefix'"); return NULL;}

        return $this->views[$prefix][$request->uri] ?? NULL;
    }
}

final class RouteDisplay {
    public function redirect(Response $response): void {
        header("Location: ".$response->response_path, true, $response->http_response_code);
        exit;
    }

    public function handle(Response $response): void {
        if ($response->http_response_code === 302) {
            foreach($response->data as $key => $value) {SessionManagement::flash_set($key, $value);}
            $this->redirect($response);
        }

        if (is_null($response->response_path) or !file_exists($response->response_path)) {
            if (!file_exists(__DIR__."/../../../../app/views/error.php")) { //TEMP CHANGE FOR THIS PROJECT ONLY!, QOL UPD FIX IN FUTURE CUSTOM ERROR PAGES!
                http_response_code(404);
                echo("Error 404, page not found");
                Debug::in(DebugLevel::DEBUG, "RouteDisplay: handle, path: '". ($response->response_path ?? 'NULL') ."', not found");
                exit;
            }

            SessionManagement::flash_set("msg", "Error 404, page not found");
            $this->redirect(new Response(302, "/error"));
        }

        $data = $response->data;

        http_response_code($response->http_response_code);
        require $response->response_path;
        exit;
    }
}

?>