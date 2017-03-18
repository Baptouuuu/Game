<?php
declare(strict_types = 1);

namespace Game\DefensiveAbility;

use Game\DefensiveAbilityInterface;

final class Shield implements DefensiveAbilityInterface
{
    private $enabled = false;
    private $usagesLeft = 3;

    public function enable(): void
    {
        if ($this->usagesLeft > 0) {
            $this->enabled = true;
            --$this->usagesLeft;
        }
    }

    public function diminish(int $damage): int
    {
        if (!$this->enabled) {
            return $damage;
        }

        $this->enabled = false;

        return 0;
    }
}
