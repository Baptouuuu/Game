<?php
declare(strict_types = 1);

require 'vendor/autoload.php';

$result = (new \Game\Match\DeathMatch)->run();

echo 'winner => ';
dump($result->winner());
echo 'loser => ';
dump($result->loser());
