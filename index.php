<?php
// Config
declare(strict_types=1);
namespace App;

const DIRECTORY = "";

// Requires
require_once __DIR__."/lib/web-runtime/WebRuntime.php";
require_once __DIR__."/app/src/actions.php";

use App\UnifiedActions;
use WebRuntime\Core\Action;
use WebRuntime\Core\ActionType;
use WebRuntime\Core\Request;
use WebRuntime\WebRuntime;

// Setup
$webruntime = new WebRuntime("127.0.0.1:8080", __DIR__."/app/views", DIRECTORY, debug_mode: true, actions: [
    new Action("search", ActionType::GET, fn(Request $request) => UnifiedActions::handle_search($request)),
    new Action("view", ActionType::GET, fn(Request $request) => UnifiedActions::view_article($request)),
]);

$webruntime->execute();

?>