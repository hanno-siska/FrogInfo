<?php
// Config
declare(strict_types=1);
namespace App;

// Requires
require_once "./app/src/datastore.php";

use App\DataStore;
use WebRuntime\Core\Request;
use WebRuntime\Core\Response;

// Classes
final class UnifiedActions {
    public static function handle_search(Request $request): Response {
        if (!key_exists("searchbar", $request->get) or strlen($request->get["searchbar"] ?? "") < 3) {return new Response(200, "./app/views/index.php", ["found_result" => false, "search_query" => ""]);}
        $datastore = new DataStore();
        $result = $datastore->get_frogs_by_search($request->get["searchbar"] ?? "");
        if (!$result) {return new Response(200, "./app/views/index.php", ["found_result" => false, "search_query" => $request->get["searchbar"] ?? ""]);}

        return new Response(200, "./app/views/index.php", ["found_result" => true, "search_query" => $request->get["searchbar"] ?? "", "result" => $result]);
    }

    public static function view_article(Request $request): Response {
        if (!key_exists("id", $request->get) or !is_numeric($request->get["id"] ?? false)) {return new Response(200, "./app/views/content/article.php", ["found_result" => false]);}
        $datastore = new DataStore();
        $result = $datastore->get_frog_by_id((int) $request->get["id"]);
        if (!$result) {return new Response(200, "./app/views/content/article.php", ["found_result" => false]);}

        return new Response(200, "./app/views/content/article.php", ["found_result" => true, "result" => $result]);
    }
}

?>