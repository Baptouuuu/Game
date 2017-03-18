<?php
declare(strict_types = 1);

namespace Game\Weapon;

use Game\Player;

interface DamageInterface
{
    public function inflict(Player $attacker, Player $opponent): void;
}
