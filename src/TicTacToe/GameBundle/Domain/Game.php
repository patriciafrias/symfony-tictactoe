<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Domain\Helper\GameOverHelper;
use TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException;
use TicTacToe\GameBundle\Exception\InvalidPositionException;
use TicTacToe\GameBundle\Exception\NoPositionsAvailableException;
use TicTacToe\GameBundle\Exception\NotEmptyPositionException;

/**
 * Class Game
 * @package TicTacToe\GameBundle\Domain
 */
class Game
{
    /** @var string */
    const USER_TEAM_ID = 'X';

    /** @var string */
    const BOT_TEAM_ID = 'O';

    /** @var null|Board */
    private $board = null;

    /**
     * Game constructor.
     * @param Board $board
     */
    public function __construct(Board $board)
    {
        $this->board = $board;
    }

    /**
     * @return null|Board
     */
    public function getBoard()
    {
        return $this->board;
    }

    /**
     * Make a move for a given player
     * @param PlayerAbstract $player
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     * @return array
     */
    public function move(PlayerAbstract $player)
    {
        // check winner before move
        $this->checkWinner();

        $this->board = $player->move($this->getBoard());

        // check winner after move
        $this->checkWinner();

        return $this->getBoard()->getStatus();
    }

    /**
     * @throws FinishedGameWithWinnerException
     */
    private function checkWinner()
    {
        $winner = GameOverHelper::getWinner($this->getBoard()->getStatus());

        if (!empty($winner)) {
            throw new FinishedGameWithWinnerException("Team $winner wins.");
        }
    }
}
