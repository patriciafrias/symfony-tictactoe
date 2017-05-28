<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Integration\Domain;

use PHPUnit\Framework\TestCase;

use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Bot;
use TicTacToe\GameBundle\Domain\Game;
use TicTacToe\GameBundle\Domain\User;

class IntegrationGameTest extends TestCase
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
        $user = new User($game::USER_TEAM_ID, 0, 0);

        $game->move($user);

        $this->assertEquals([['X', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\InvalidPositionException
     */
    public function testMoveUserToInvalidPositionShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 99, 99);

        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NotEmptyPositionException
     */
    public function testMoveUserToBusyPositionShouldThrowException()
    {
        $board = new Board(3);
        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 0);

        $game->move($user);
        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NoPositionsAvailableException
     */
    public function testMoveUserWhenThereIsNoMoreMovesShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', 'O', 'O'], ['O', 'X', 'X'], ['X', 'O', 'O']]);

        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 0);

        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByRowShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', 'X', 'X'], ['', '', ''], ['', '', '']]);

        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 2);

        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByColumnShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', '', ''], ['X', '', ''], ['X', '', '']]);

        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 2);

        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByMainDiagonalShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', '', ''], ['', 'X', ''], ['', '', 'X']]);

        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 2);

        $game->move($user);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerBySecondDiagonalShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['', '', 'X'], ['', 'X', ''], ['X', '', '']]);

        $game = new Game($board);
        $user = new User($game::USER_TEAM_ID, 0, 2);

        $game->move($user);
    }

    public function testMoveBotShouldReturnModifiedBoardWithNewBotPosition()
    {
        $board = new Board(3);
        $game = new Game($board);
        $bot = new Bot($game::BOT_TEAM_ID);

        $game->move($bot);

        $this->assertEquals([['', 'O', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NoPositionsAvailableException
     */
    public function testMoveBotWhenThereIsNoMoreMovesShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', 'O', 'O'], ['O', 'X', 'X'], ['X', 'O', 'O']]);

        $game = new Game($board);
        $bot = new Bot($game::BOT_TEAM_ID);

        $game->move($bot);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveBotWhenThereIsWinnerShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X', 'X', 'X'], ['', '', ''], ['', '', '']]);

        $game = new Game($board);
        $bot = new Bot($game::BOT_TEAM_ID);

        $game->move($bot);
    }
}
