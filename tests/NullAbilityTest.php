<?php
declare(strict_types = 1);

namespace Tests\Game;

use Game\{
    NullAbility,
    AbilityInterface
};
use PHPUnit\Framework\TestCase;

class NullAbilityTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            AbilityInterface::class,
            new NullAbility
        );
    }

    public function testEnable()
    {
        $this->assertNull((new NullAbility)->enable());
    }
}
