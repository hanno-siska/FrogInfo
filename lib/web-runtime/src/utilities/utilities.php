<?php
// Config
declare(strict_types=1);
namespace WebRuntime\Utilities;

use InvalidArgumentException;
use RuntimeException;

// Error Classes
class FileNotFoundException extends RuntimeException {}

// Classes
final class ConfigMgr {
    private static array $config = [];

    public static function scan(string $config_path): void {
        if (!is_file($config_path)) {
            throw new FileNotFoundException("'$config_path', not found");
        }

        $intermediary = parse_ini_file($config_path, true);
        if ($intermediary === false) {
            throw new RuntimeException("While parsing '$config_path'");
        }

        self::$config = $intermediary;
    }

    public static function assert(array $paths): void {
        if (!self::$config) {
            throw new RuntimeException("Config doesn't exist! (Did u load it with scan?)");
        }

        foreach ($paths as $path) {
            $tmp = self::$config;

            if (!is_array($path)) {
                throw new InvalidArgumentException("Expected input to be [['key1', 'key2'], ...]");
            }

            foreach ($path as $key) {
                if (!array_key_exists($key, $tmp)) {
                    throw new RuntimeException("Array keys: ".implode(".", $path).", specific key stopped: $key");
                }
                $tmp = $tmp[$key];
            }
        }
    }

    public static function get(array $keys, mixed $default = null): mixed {
        $tmp = self::$config;
        foreach ($keys as $key) {
            if (!array_key_exists($key, $tmp)) {return $default;}
            $tmp = $tmp[$key];
        }
        return $tmp;
    }
}

final class PathUtils {
    public static function build(string $basepath, string ...$pathables): string {
        $path = rtrim($basepath, "/\\");
        foreach ($pathables as $p) {
            if ($p === "") {continue;}
            $path .= "/" . trim($p, "/\\");
        }

        return $path;
    }
}
?>