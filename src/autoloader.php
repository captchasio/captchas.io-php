<?php

spl_autoload_register(function ($class) {
    $prefix = 'CaptchasIO\\';

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) return;

    $relativeClass = substr($class, $len);

    $file = __DIR__ . '/' . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) require $file;
});
