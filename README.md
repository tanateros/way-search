Install
=
<code> composer require way-search/different-directions "dev-master" </code>

Require
=
- PHP 7.*+

Example use with test data
=
```php
<?php

require_once __DIR__ . "/vendor/autoload.php";

$filePath = __DIR__ . "/vendor/way-search/different-directions/example/data/sample.in";

$parser = new \WaySearch\Service\DirectionFileParser();
$directions = $parser->prepareData($filePath)->getDirections();
$cases = new \WaySearch\Service\DirectionCases($directions);

foreach ($cases as $case) {
    $point = $case->getAvgEndPoint();
    $diff = $case->getDifference();
    echo "{$point->x} {$point->y} {$diff}" . PHP_EOL;
}
```
