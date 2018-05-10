<?php

require_once __DIR__ . "/vendor/autoload.php";

$filePath = __DIR__ . "/example/data/sample.in";

$parser = new \WaySearch\Service\DirectionFileParser($filePath);
$directions = $parser->getDirections();
$cases = new \WaySearch\Service\DirectionCases($directions);

foreach ($cases as $case) {
    $point = $case->getAvgEndPoint();
    $diff = $case->getDifference();
    echo "{$point->x} {$point->y} {$diff}" . PHP_EOL;
}
