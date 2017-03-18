<?php
declare(strict_types = 1);

namespace Tests\Game;

use Game\{
    Player,
    DefensiveAbilityInterface,
    OffensiveAbilityInterface,
    AbilityInterface,
    Weapon,
    WeaponInterface,
    Weapon\DamageInterface,
    Weapon\Damage
};
use PHPUnit\Framework\TestCase;

class PlayerTest extends TestCase
{
    public function testDefaultHealth()
    {
        $this->assertSame(100, (new Player('foo'))->health());
    }

    public function testIsDead()
    {
        $player = new Player('foo');

        $this->assertFalse($player->isDead());
        $player->damage(100);
        $this->assertTrue($player->isDead());
    }

    public function testNoDefenseByDefault()
    {
        $player = new Player('foo');

        foreach (range(0, 99) as $round) {
            $player->damage(1);
        }

        $this->assertTrue($player->isDead());
    }

    public function testNoDefenseByDefaultEvenWhenEnablingAbility()
    {
        $player = new Player('foo');

        foreach (range(0, 99) as $round) {
            $player->enableAbility();
            $player->damage(1);
        }

        $this->assertTrue($player->isDead());
    }

    public function testAbilityNeverCalledIfNeitherOffensiveNorDefensive()
    {
        $ability = new class implements AbilityInterface {
            public static $enabled = false;

            public function enable(): void
            {
                self::$enabled = true;
            }
        };
        $player = new Player('foo', get_class($ability));

        $player->enableAbility();
        $this->assertFalse($ability::$enabled);
    }

    public function testEnableAbility()
    {
        $ability = new class implements DefensiveAbilityInterface {
            public static $enabled = false;

            public function enable(): void
            {
                self::$enabled = true;
            }

            public function diminish(int $damage): int
            {
            }
        };
        $player = new Player('foo', get_class($ability));

        $this->assertNull($player->enableAbility());
        $this->assertTrue($ability::$enabled);
    }

    public function testAttackWithOffensiveAbility()
    {
        $ability = new class(new Weapon) implements OffensiveAbilityInterface {
            public function __construct(WeaponInterface $weapon)
            {
            }

            public function enable(): void
            {
            }

            public function hit(Player $opponent): DamageInterface
            {
                return new Damage(20);
            }
        };
        $player = new Player('foo', get_class($ability));
        $opponent = new Player('foo');

        $damage = $player->attack($opponent);

        $this->assertInstanceOf(Damage::class, $damage);
        $this->assertSame(100, $player->health());
        $this->assertSame(80, $opponent->health());
    }

    public function testAttackWithDefensiveAbility()
    {
        $ability = new class implements DefensiveAbilityInterface {
            public function enable(): void
            {
            }

            public function diminish(int $damage): int
            {
                return $damage - 5;
            }
        };
        $player = new Player('foo');
        $opponent = new Player('foo', get_class($ability));

        $damage = $player->attack($opponent);

        $this->assertInstanceOf(Damage::class, $damage);
        $this->assertSame(100, $player->health());
        $this->assertSame(95, $opponent->health());
    }
}
