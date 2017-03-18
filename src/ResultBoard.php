<?php
declare(strict_types = 1);

namespace Game;

final class ResultBoard
{
    private $players;
    private $frozen = false;
    private $winner;
    private $loser;

    public function __construct(Player ...$players)
    {
        if (count($players) < 2) {
            throw new \DomainException('at least 2 players required');
        }

        $this->players = $players;
    }

    public function winner(): Player
    {
        if ($this->winner) {
            return $this->winner;
        }

        usort($this->players, function(Player $a, Player $b): bool {
            return $a->health() < $b->health();
        });

        return reset($this->players);
    }

    public function loser(): Player
    {
        if ($this->loser) {
            return $this->loser;
        }

        usort($this->players, function(Player $a, Player $b): bool {
            return $a->health() > $b->health();
        });

        return reset($this->players);
    }

    public function freeze(): void
    {
        if ($this->frozen) {
            return;
        }

        $this->winner = $this->winner();
        $this->loser = $this->loser();
        $this->frozen = true;
    }
}
