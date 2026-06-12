<?php
$title = "Error";
$content = "error";
$data = $data ?? [];
include __DIR__."/../static/templates/page_start.php";

// Requires
use WebRuntime\WebRuntimeSession;
echo(WebRuntimeSession::flash_get("msg", "There's nothing here :)"));
?>

<img src="/app/static/assets/error_duck.webp" alt="A yellow duckling" width="128" height="128">

<?php
include __DIR__."/../static/templates/page_end.php";
?>