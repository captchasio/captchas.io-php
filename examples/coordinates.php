<?php

set_time_limit(130);

require(__DIR__ . '/../src/autoloader.php');

$solver = new \CaptchasIO\CaptchasIO('YOUR_API_KEY');

try {
    $result = $solver->coordinates(__DIR__ . '/images/grid.jpg');
} catch (\Exception $e) {
    die($e->getMessage());
}

die('Captcha solved: ' . $result->code);
