<?php
declare(strict_types = 1);

namespace Tests\Game\OffensiveAbility;

use Game\{
    OffensiveAbility\DamageMultiplicator,
    OffensiveAbilityInterface,
    Weapon,
    Player,
    Weapon\Damage,
    Weapon\Backfire
};
use PHPUnit\Framework\TestCase;

class DamageMultiplicatorTest extends TestCase
{
    public function testInterface()
    {
        $this->assertInstanceOf(
            OffensiveAbilityInterface::class,
            new DamageMultiplicator(
                new Weapon
            )
        );
    }

    public function testEnable()
    {
        $multiplicator = new DamageMultiplicator(new Weapon);

        $this->assertNull($multiplicator->enable());
    }

    public function testHitWithoutBeingEnabled()
    {
        $weapon = new DamageMultiplicator(new Weapon);
        $opponent = new Player('foo');

        $damage = $weapon->hit($opponent);

        $this->assertInstanceOf(Damage::class, $damage);
        $this->assertSame(100, $opponent->health());
        $damage->inflict(new Player('foo'), $opponent);
        $this->assertSame(90, $opponent->health());
    }

    public function testIncreaseDamageWhenEnabled()
    {
        $weapon = new DamageMultiplicator(new Weapon);
        $opponent = new Player('foo');
        $weapon->enable();

        $damage = $weapon->hit($opponent);

        if ($damage instanceof Backfire) {
            return; //abort test
        }

        $this->assertInstanceOf(Damage::class, $damage);
        $this->assertSame(100, $opponent->health());
        $damage->inflict(new Player('foo'), $opponent);
        $this->assertSame(80, $opponent->health());
    }

    public function testBackfireInOneOutOfFiveChances()
    {
        $weapon = new DamageMultiplicator(new Weapon);
        $opponent = new Player('foo');
        $attacker = new Player('foo');
        $backfires = 0;
        $backfire = null;

        foreach (range(0, 99) as $round) {
            $weapon->enable();
            $damage = $weapon->hit($opponent);

            if ($damage instanceof Backfire) {
                ++$backfires;
                $backfire = $damage;
            }
        }

        $this->assertTrue($backfires > 0);
        $this->assertTrue($backfires < 25);
        $backfire->inflict($attacker, $opponent);
        $this->assertSame(85, $attacker->health());
        $this->assertSame(100, $opponent->health());
    }

    public function testDisableOneCalled()
    {
        $weapon = new DamageMultiplicator(new Weapon);
        $opponent = new Player('foo');
        $attacker = new Player('foo');
        $weapon->enable();
        $weapon->hit($opponent);

        foreach (range(0, 99) as $round) {
            $damage = $weapon->hit($opponent);

            $this->assertInstanceOf(Damage::class, $damage);
        }
    }
}
