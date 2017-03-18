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
use Innmind\Immutable\Set;

final class DeathMatch extends Match
{
    private $players;
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
        $this->players = (new Set(Player::class))
            ->add(new Player($this->randomAbility()))
            ->add(new Player($this->randomAbility()))
            ->add(new Player($this->randomAbility()));

        return $this->players->toPrimitive();
    }

    protected function runRound(): void
    {
        $attacker = $this->players->current();
        $this->players->next();
        $this->players->valid() ?: $this->players->rewind();
        $opponent = $this->players->current();

        rand(0, 3) !== 0 ?: $attacker->enableAbility();
        rand(0, 3) !== 0 ?: $opponent->enableAbility();

        $attacker->attack($opponent);
    }

    protected function isMatchFinished(): bool
    {
        return $this->players->reduce(
            false,
            function(bool $carry, Player $player): bool
            {
                return $carry ?: $player->isDead();
            }
        );
    }

    private function randomAbility(): string
    {
        return $this->abilities[rand(0, 2)];
    }
}
