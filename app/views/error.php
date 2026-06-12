<?php
$title = "Home";
$content = "home";
$data = $data ?? [];
include __DIR__."/../static/templates/page_start.php";

// Requires
use WebRuntime\WebRuntimeSession;

echo(WebRuntimeSession::flash_get("msg", "There's nothing here :)"));
include __DIR__."/../static/templates/page_end.php";
?>