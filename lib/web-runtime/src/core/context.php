<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Core;

// Classes
final readonly class Request {
    public string $host;
    public string $uri;

    public string $method;
    public array $post;
    public array $get;

    public function __construct() {
        $this->host = $_SERVER["HTTP_HOST"] ?? "";
        $this->uri = parse_url($_SERVER["REQUEST_URI"] ?? "/", PHP_URL_PATH);

        $this->method = $_SERVER["REQUEST_METHOD"];
        $this->get = $_GET;
        $this->post = $_POST;
    }
}

final class Response {
    public function __construct(
        public int $http_response_code,
        public ?string $response_path = NULL,
        public array $data = []
    ){}
}
?>