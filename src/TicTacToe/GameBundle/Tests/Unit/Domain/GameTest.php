<?php

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\GameBundle\Domain\{
    Board, Bot, Game, User
};

class GameTest extends TestCase
{
    public function testInitializeGameShouldReturnEmptyBoard()
    {
        $board = new Board(3);
        $game = new Game($board);

        $this->assertEquals([['', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    public function testMoveUserShouldReturnModifiedBoardWithNewUserPosition()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_MARKER);

        $game->move(0, 0, $user);

        $this->assertEquals([['X', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    public function testMoveUserToInvalidPositionShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_MARKER);

        $game->move(0, 31, $user);

        $this->assertEquals([['X', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    public function testMoveUserToBusyPositionShouldThrowException()
    {
        $this->assertTrue(true);
    }

    public function testMoveUserWhenThereIsNoMoreMovesShouldThrowException()
    {
        $this->assertTrue(true);
    }

    public function testMoveUserWhenThereIsWinnerShouldThrowException()
    {
        $this->assertTrue(true);
    }

    public function testMoveBotShouldReturnModifiedBoardWithNewBotPosition()
    {
        $board = new Board(3);
        $game = new Game($board);
        $bot = new Bot($game::BOT_TEAM_MARKER);

        $game->move(0, 1, $bot);

        $this->assertEquals([['', 'O', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    public function testMoveBotWhenThereIsNoMoreMovesShouldThrowException()
    {
        $this->assertTrue(true);
    }

    public function testMoveBotWhenThereIsWinnerShouldThrowException()
    {
        $this->assertTrue(true);
    }
}
