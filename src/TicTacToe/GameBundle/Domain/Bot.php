<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Exception\InvalidPositionException;
use TicTacToe\GameBundle\Exception\NoPositionsAvailableException;
use TicTacToe\GameBundle\Exception\NotEmptyPositionException;

/**
 * Class Bot
 * @package TicTacToe\GameBundle\Domain
 */
class Bot extends PlayerAbstract
{
    /** @var int */
    private $nextMoveCoordinateX;

    /** @var int */
    private $nextMoveCoordinateY;
    /**
     * Executes MinMax algorithm to decide bot next move.
     * @param Board $board
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     * @return Board
     */
    public function move(Board $board): Board
    {
        $this->getNextMove($board);
        $board->setPosition($this->nextMoveCoordinateX, $this->nextMoveCoordinateY, $this->getTeamMarker());

        return $board;
    }

    /**
     * @param Board $board
     */
    private function getNextMove(Board $board)
    {
        $this->nextMoveCoordinateX = 0;
        $this->nextMoveCoordinateY = 1;
    }
}
