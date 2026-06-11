<?php
// Config
declare(strict_types=1);

// Requires
require_once __DIR__."/lib/web-runtime/WebRuntime.php";
use WebRuntime\WebRuntime;

// Setup
$webruntime = new WebRuntime("127.0.0.1:8080", __DIR__."/app/views", debug_mode: true);

$webruntime->execute();

?>