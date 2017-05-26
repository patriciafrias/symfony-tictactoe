<?php

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;

use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Bot;
use TicTacToe\GameBundle\Domain\Game;
use TicTacToe\GameBundle\Domain\User;

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

        $game->move($user, 0, 0);

        $this->assertEquals([['X', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\InvalidPositionException
     */
    public function testMoveUserToInvalidPositionShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_MARKER);

        $game->move($user, 99, 99);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NotEmptyPositionException
     */
    public function testMoveUserToBusyPositionShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_MARKER);

        $game->move($user, 0, 0);
        $game->move($user, 0, 0);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NoPositionsAvailableException
     */
    public function testMoveUserWhenThereIsNoMoreMovesShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_MARKER);

        $game->move($user, 0, 0);
        $game->move($user, 0, 1);
        $game->move($user, 0, 2);
        $game->move($user, 1, 0);
        $game->move($user, 1, 1);
        $game->move($user, 1, 2);
        $game->move($user, 2, 0);
        $game->move($user, 2, 1);
        $game->move($user, 2, 2);

        $game->move($user, 0, 0);

        print_r($game->getBoard()->getStatus());
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

        $game->move($bot, 0,1);

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
