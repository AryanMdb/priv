<?php
spl_autoload_register(function ($class) {
    $baseDir = __DIR__ . '/vendor/pusher/src/';

    // Convert namespace to path
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});
