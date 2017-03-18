<?php
declare(strict_types = 1);

namespace Tests\Game\DefensiveAbility;

use Game\{
    DefensiveAbility\NullDefense,
    DefensiveAbilityInterface
};
use PHPUnit\Framework\TestCase;

class NullDefenseTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            DefensiveAbilityInterface::class,
            new NullDefense
        );
    }

    public function testEnable()
    {
        $this->assertNull((new NullDefense)->enable());
    }

    public function testDoesntDiminishByDefault()
    {
        $this->assertSame(42, (new NullDefense)->diminish(42));
    }

    public function testDoesntDiminishWhenEnabled()
    {
        $defense = new NullDefense;
        $defense->enable();

        $this->assertSame(42, $defense->diminish(42));
    }
}
