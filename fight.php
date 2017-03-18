<?php
declare(strict_types = 1);

require 'vendor/autoload.php';

$match = new \Game\Match\RandomMatch(
    new \Game\Match\DeathMatch,
    new \Game\Match\Duel
);
$result = $match->run();

echo 'type => ';
dump($match->type());
echo 'winner => ';
dump($result->winner());
echo 'loser => ';
dump($result->loser());
