<?php
declare(strict_types = 1);

namespace Tests\Game\Weapon;

use Game\{
    Weapon\Damage,
    Weapon\DamageInterface,
    Player
};
use PHPUnit\Framework\TestCase;

class DamageTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            DamageInterface::class,
            new Damage(10)
        );
    }

    public function testInflict()
    {
        $damage = new Damage(30);
        $attacker = new Player;
        $opponent = new Player;

        $this->assertNull($damage->inflict($attacker, $opponent));
        $this->assertSame(100, $attacker->health());
        $this->assertSame(70, $opponent->health());
    }

    /**
     * @expectedException DomainException
     * @expectedExceptionMessage damage cannot be negative
     */
    public function testThrowWhenNegativeDamage()
    {
        new Damage(-1);
    }
}
