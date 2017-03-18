<?php
declare(strict_types = 1);

namespace Game;

use Game\{
    DefensiveAbility\NullDefense,
    Weapon\DamageInterface
};

final class Player
{
    private $health = 100;
    private $weapon;
    private $defense;
    private $ability;

    public function __construct(string $ability = null)
    {
        $weapon = new Weapon;
        $defense = new NullDefense;

        switch (true) {
            case is_subclass_of($ability, OffensiveAbilityInterface::class):
                $weapon = new $ability($weapon);
                $ability = $weapon;
                break;

            case is_subclass_of($ability, DefensiveAbilityInterface::class):
                $defense = new $ability;
                $ability = $defense;
                break;

            default:
                $ability = new NullAbility;
                break;
        }

        $this->weapon = $weapon;
        $this->defense = $defense;
        $this->ability = $ability;
    }

    public function enableAbility(): void
    {
        $this->ability->enable();
    }

    public function attack(self $player): DamageInterface
    {
        $damage = $this->weapon->hit($player);
        $damage->inflict($this, $player);

        return $damage;
    }

    public function damage(int $damage): void
    {
        $this->health -= $this->defense->diminish($damage);
        $this->health = max(0, $this->health);
    }

    public function health(): int
    {
        return $this->health;
    }

    public function isDead(): bool
    {
        return $this->health === 0;
    }
}
