<?php
declare(strict_types = 1);

namespace Game;

interface DefensiveAbilityInterface extends AbilityInterface
{
    public function diminish(int $damage): int;
}
