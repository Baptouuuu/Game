<?php
declare(strict_types = 1);

namespace Tests\Game;

use Game\{
    ResultBoard,
    Player
};
use PHPUnit\Framework\TestCase;

class ResultBoardtest extends TestCase
{
    /**
     * @expectedException DomainException
     * @expectedExceptionMessage at least 2 players required
     */
    public function testThrowWhenNotEnoughPlayers()
    {
        new ResultBoard;
    }

    public function testWinner()
    {
        $alice = new Player;
        $bob = new Player;
        $alice->damage(10);
        $board = new ResultBoard($alice, $bob);

        $this->assertSame($bob, $board->winner());
        $bob->damage(50);
        $this->assertSame($alice, $board->winner());
    }

    public function testLoser()
    {
        $alice = new Player;
        $bob = new Player;
        $alice->damage(10);
        $board = new ResultBoard($alice, $bob);

        $this->assertSame($alice, $board->loser());
        $bob->damage(50);
        $this->assertSame($bob, $board->loser());
    }

    public function testWinnerWhenFrozen()
    {
        $alice = new Player;
        $bob = new Player;
        $alice->damage(10);
        $board = new ResultBoard($alice, $bob);

        $this->assertNull($board->freeze());
        $this->assertSame($bob, $board->winner());
        $bob->damage(50);
        $this->assertSame($bob, $board->winner());
    }

    public function testLoserWhenFrozen()
    {
        $alice = new Player;
        $bob = new Player;
        $alice->damage(10);
        $board = new ResultBoard($alice, $bob);

        $this->assertNull($board->freeze());
        $this->assertSame($alice, $board->loser());
        $bob->damage(50);
        $this->assertSame($alice, $board->loser());
    }
}
