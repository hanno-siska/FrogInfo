<?php
// Config
declare(strict_types=1);
namespace App;

// Requires
use WebRuntime\Core\Request;
use WebRuntime\Core\Response;

// Classes
final class UnifiedActions {
    public static function handle_search(Request $request): Response {
        return new Response(200, "./app/views/index.php", ["found_result" => false, "search_query" => $request->get["searchbar"] ?? ""]);
    }

    public static function view_article(Request $request): Response {
        return new Response(200, "./app/views/content/article.php", [$request]);
    }
}

?>