<?php
declare(strict_types = 1);

namespace Tests\Game\Weapon;

use Game\{
    Weapon\Backfire,
    Weapon\DamageInterface,
    Player
};
use PHPUnit\Framework\TestCase;

class BackfireTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            DamageInterface::class,
            new Backfire(10)
        );
    }

    public function testInflict()
    {
        $damage = new Backfire(30);
        $attacker = new Player('foo');
        $opponent = new Player('foo');

        $this->assertNull($damage->inflict($attacker, $opponent));
        $this->assertSame(70, $attacker->health());
        $this->assertSame(100, $opponent->health());
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage damage cannot be negative
     */
    public function testThrowWhenNegativeDamage()
    {
        new Backfire(-1);
    }
}
