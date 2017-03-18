<?php
declare(strict_types = 1);

namespace Game;

use Game\Weapon\DamageInterface;

interface WeaponInterface
{
    public function hit(Player $opponent): DamageInterface;
}
