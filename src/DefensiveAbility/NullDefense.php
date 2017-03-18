<?php
declare(strict_types = 1);

namespace Game\DefensiveAbility;

use Game\DefensiveAbilityInterface;

final class NullDefense implements DefensiveAbilityInterface
{
    public function enable(): void
    {
    }

    public function diminish(int $damage): int
    {
        return $damage;
    }
}
