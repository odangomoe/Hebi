<?php
exec(__DIR__ . '/run.sh', $std);
echo implode("\n", $std);
require(__DIR__ . '/../vendor/autoload.php');
