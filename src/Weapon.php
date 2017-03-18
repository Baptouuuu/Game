<?php
declare(strict_types = 1);

namespace Game;

use Game\Weapon\{
    Damage,
    DamageInterface
};

final class Weapon implements WeaponInterface
{
    public function hit(Player $opponent): DamageInterface
    {
        return new Damage(10);
    }
}
