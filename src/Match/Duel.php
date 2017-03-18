<?php
declare(strict_types = 1);

namespace Game\Match;

use Game\{
    Match,
    OffensiveAbility\DamageMultiplicator,
    DefensiveAbility\Shield,
    NullAbility,
    Player
};

final class Duel extends Match
{
    private $alice;
    private $bob;
    private $round = 0;
    private $abilities = [
        DamageMultiplicator::class,
        Shield::class,
        NullAbility::class
    ];

    /**
     * {@inheritdoc}
     */
    protected function gatherPlayers()
    {
        $this->alice = new Player($this->randomAbility());
        $this->bob = new Player($this->randomAbility());

        return [$this->alice, $this->bob];
    }

    protected function runRound(): void
    {
        $attacker = $this->round % 2 === 0 ? $this->alice : $this->bob;
        $opponent = $this->round % 2 === 1 ? $this->alice : $this->bob;

        rand(0, 3) !== 0 ?: $attacker->enableAbility();
        rand(0, 3) !== 0 ?: $opponent->enableAbility();

        $attacker->attack($opponent);

        ++$this->round;
    }

    protected function isMatchFinished(): bool
    {
        return $this->round === 5;
    }

    private function randomAbility(): string
    {
        return $this->abilities[rand(0, 2)];
    }
}
