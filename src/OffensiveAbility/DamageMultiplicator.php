<?php
declare(strict_types = 1);

namespace Game\OffensiveAbility;

use Game\{
    OffensiveAbilityInterface,
    Player,
    WeaponInterface,
    Weapon\DamageInterface,
    Weapon\Damage,
    Weapon\Backfire
};

final class DamageMultiplicator implements OffensiveAbilityInterface
{
    private $weapon;
    private $enabled = false;

    public function __construct(WeaponInterface $weapon)
    {
        $this->weapon = $weapon;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function hit(Player $opponent): DamageInterface
    {
        if (!$this->enabled) {
            return $this->weapon->hit($opponent);
        }

        $probability = rand(0, 4);
        $damage = new Damage(20);

        if ($probability === 0) {
            $damage = new Backfire(15);
        }

        $this->enabled = false;

        return $damage;
    }
}
