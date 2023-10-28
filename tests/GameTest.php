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

        $game = new Game();
        $game->board[1][1] = new Stone(Color::Black);
        $game->board[1][2] = new Stone(Color::White);
        $game->board[1][3] = new Stone(Color::White);

        $game->put(1, 4);
        $this->assertEquals(Color::Black, $game->board[1][2]->color);
        $this->assertEquals(Color::Black, $game->board[1][3]->color);
    }

    public function testToggleColor(): void
    {
        $this->assertEquals(Color::White, Color::Black->toggle());
        $this->assertEquals(Color::Black, Color::White->toggle());
    }

    public function testPlay(): void
    {
        $game = new Game();
        $game->board[1][1] = new Stone(Color::Black);
        $game->board[1][2] = new Stone(Color::White);

        $game->play(1, 3);
        $this->assertEquals(Color::Black, $game->board[1][2]->color);

        $game = new Game();
        $game->board[4][4] = new Stone(Color::White);
        $game->board[4][5] = new Stone(Color::Black);
        $game->board[5][4] = new Stone(Color::Black);
        $game->board[5][5] = new Stone(Color::White);

        $game->play(4, 3);
        $this->assertEquals(Color::White, $game->turn);
        $game->play(3, 3);
        $this->assertEquals(Color::Black, $game->turn);
        $game->play(3, 4);
        $this->assertEquals(Color::White, $game->turn);
        $game->play(3, 5);
        $this->assertEquals(Color::Black, $game->turn);
        $game->play(4, 6);
        $this->assertEquals(Color::White, $game->turn);

    }

    public function testResult(): void
    {
        $game = new Game();
        $game->board[1][1] = new Stone(Color::Black);
        $game->board[1][2] = new Stone(Color::White);
        $game->board[1][3] = new Stone(Color::White);
        $game->board[1][4] = new Stone(Color::White);

        $this->assertEquals('白の勝ち（ 1 対 3 ）', $game->result());
        
    }

}
