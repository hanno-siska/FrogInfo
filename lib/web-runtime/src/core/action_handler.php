<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Core;

// Requires
use WebRuntime\Core\Response;
use WebRuntime\Core\Request;
use WebRuntime\Services\Debug;
use WebRuntime\Services\DebugLevel;

use const App\DIRECTORY;

// Classes
enum ActionType: string {
    case POST = "POST";
    case GET = "GET";
}

final class Action {
    public function __construct(
        public string $name,
        public ActionType $type,
        public mixed $func
    ){}
}

final class Actions {
    public function __construct(
        private array $actions
    ) {}

    public function execute(Request $request, ?string $response_path): Response {
        if ($request->method === "POST") {$data = $request->post;}
        else {$data = $request->get;}

        if ($request->method === "GET" and !$data) {return new Response(200, $response_path);}

        if (!key_exists("exec_action", $data)) {
            Debug::in(DebugLevel::DEBUG, "Actions: 'exec_action' missing in form/query_string");
            return new Response(302, DIRECTORY."/error", ["msg" => "Error 400, requested action not found"]); // TEMPORARY FIXES!!!!
        }

        foreach($this->actions as $action) {
            if ($action->name === $data["exec_action"] and $action->type->value === $request->method) {
                $func = $action->func;
                $action_result = $func($request);
                return new Response($action_result->http_response_code, $action_result->response_path ?? $response_path, $action_result->data);
            }
        }

        Debug::in(DebugLevel::DEBUG, "Actions: action '".$data["exec_action"]."', not found");
        return new Response(302, DIRECTORY."/error", ["msg" => "Error 404, requested action not found"]);  // TEMPORARY FIXES!!!!
    }
}

?>