<?php
declare(strict_types = 1);

namespace Tests\Game\DefensiveAbility;

use Game\{
    DefensiveAbility\Shield,
    DefensiveAbilityInterface
};
use PHPUnit\Framework\TestCase;

class ShieldTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            DefensiveAbilityInterface::class,
            new Shield
        );
    }

    public function testEnable()
    {
        $this->assertNull((new Shield)->enable());
    }

    public function testDoesntDiminishByDefault()
    {
        $this->assertSame(42, (new Shield)->diminish(42));
    }

    public function testDiminishWhenEnabled()
    {
        $shield = new Shield;
        $shield->enable();

        $this->assertSame(0, $shield->diminish(42));
    }

    public function testDisableOnceCalled()
    {
        $shield = new Shield;
        $shield->enable();

        $this->assertSame(0, $shield->diminish(42));
        $this->assertSame(42, $shield->diminish(42));
    }

    public function testDoesntDiminishWhenEnabledMoreThan3Times()
    {
        $shield = new Shield;
        foreach ([0, 1, 2] as $value) {
            $shield->enable();
            $this->assertSame(0, $shield->diminish(42));
        }

        $shield->enable();
        $this->assertSame(42, $shield->diminish(42));
    }
}
