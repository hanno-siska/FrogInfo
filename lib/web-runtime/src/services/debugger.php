<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Services;

// Enums & Classes
enum DebugLevel: string {
    case INFO = "Info   ";
    case WARNING = "Warning";
    case DEBUG = "Debug  ";
}

class Debug {
    public static bool $active = false;
    private static mixed $stream = NULL;

    public static function setup(mixed $stream): void {
        self::$stream = $stream;
        self::in(DebugLevel::INFO, "Setup Debugger with stream object");
    }

    public static function in(DebugLevel $level, string $message): void {
        if (!self::$active) {return;}
        if (is_null(self::$stream)) {
            self::$stream = fopen("php://stderr", "w");
            self::in(DebugLevel::WARNING, "Debug, setup function, no stream passed in using default STDERR (call Debug::setup)");
        }

        $timestamp = date("H:i:s", time());
        $format = "[WebRuntime | $level->value | $timestamp]: ".$message."\n";
        fwrite(self::$stream, $format);
        fflush(self::$stream);
    }
}

?>