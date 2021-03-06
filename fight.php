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
echo 'winner => '.$result->winner()."\n";
dump($result->winner());
echo 'loser => '.$result->loser()."\n";
dump($result->loser());
