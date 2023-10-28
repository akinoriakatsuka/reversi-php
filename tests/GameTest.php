<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Reversi\Game as Game;
use Reversi\Stone as Stone;
use Reversi\Color as Color;

final class GameTest extends TestCase
{

    public function testFlip(): void
    {
        $stone = new Stone(Color::Black);
        $stone->flip();
        $this->assertEquals(Color::White, $stone->color);
        $stone->flip();
        $this->assertEquals(Color::Black, $stone->color);
    }

    public function testCanPut(): void
    {
        $game = new Game();
        $game->board[1][1] = new Stone(Color::White);
        $game->board[1][2] = new Stone(Color::Black);
        $this->assertTrue($game->canPut(1, 3, Color::White));
        $this->assertFalse($game->canPut(1, 3, Color::Black));
    }

    public function testPut(): void
    {
        $game = new Game();
        $game->board[1][1] = new Stone(Color::Black);
        $game->board[1][2] = new Stone(Color::White);

        $game->put(1, 3);
        $this->assertEquals(Color::Black, $game->board[1][2]->color);
    }

    public function testPlay(): void
    {
        $game = new Game();
        $game->board[1][1] = new Stone(Color::Black);
        $game->board[1][2] = new Stone(Color::White);

        $game->play(1, 3);
        $this->assertEquals(Color::Black, $game->board[1][2]->color);
    }
}
