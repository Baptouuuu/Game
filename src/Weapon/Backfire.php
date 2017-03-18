<?php
declare(strict_types = 1);

namespace Game\Weapon;

use Game\Player;

final class Backfire implements DamageInterface
{
    private $value;

    public function __construct(int $value)
    {
        if ($value < 0) {
            throw new \DomainException('damage cannot be negative');
        }

        $this->value = $value;
    }

    public function inflict(Player $attacker, Player $opponent): void
    {
        $attacker->damage($this->value);
    }
}
