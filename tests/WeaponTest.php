<?php
declare(strict_types = 1);

namespace Tests\Game;

use Game\{
    Weapon,
    WeaponInterface,
    Player,
    Weapon\Damage
};
use PHPUnit\Framework\TestCase;

class WeaponTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            WeaponInterface::class,
            new Weapon
        );
    }

    public function testHit()
    {
        $weapon = new Weapon;
        $opponent = new Player('foo');

        $damage = $weapon->hit($opponent);

        $this->assertInstanceOf(Damage::class, $damage);
        $this->assertSame(100, $opponent->health());
        $damage->inflict(new Player('foo'), $opponent);
        $this->assertSame(90, $opponent->health());
    }
}
