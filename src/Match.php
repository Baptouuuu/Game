<?php
declare(strict_types = 1);

namespace Game;

abstract class Match
{
    final public function run(): ResultBoard
    {
        $board = new ResultBoard(...$this->gatherPlayers());

        while(!$this->isMatchFinished()) {
            $this->runRound();
        }

        $board->freeze();

        return $board;
    }

    /**
     * @return Player[]
     */
    abstract protected function gatherPlayers();
    abstract protected function runRound(): void;
    abstract protected function isMatchFinished(): bool;
}
