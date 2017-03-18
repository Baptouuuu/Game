<?php
declare(strict_types = 1);

namespace Game;

interface OffensiveAbilityInterface extends AbilityInterface, WeaponInterface
{
    public function __construct(WeaponInterface $weapon);
}
