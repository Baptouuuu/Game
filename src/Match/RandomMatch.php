<?php
declare(strict_types = 1);

namespace Game\Match;

use Game\Match;

final class RandomMatch extends Match
{
    private $matches;
    private $current;

    public function __construct(Match ...$matches)
    {
        $this->matches = $matches;
    }

    public function type(): string
    {
        return get_class($this->current);
    }

    /**
     * {@inheritdoc}
     */
    protected function gatherPlayers()
    {
        $this->current = $this->matches[rand(0, count($this->matches) - 1)];

        return $this->current->gatherPlayers();
    }

    protected function runRound(): void
    {
        $this->current->runRound();
    }

    protected function isMatchFinished(): bool
    {
        return $this->current->isMatchFinished();
    }
}
