<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Exception\InvalidPositionException;
use TicTacToe\GameBundle\Exception\NoPositionsAvailableException;
use TicTacToe\GameBundle\Exception\NotEmptyPositionException;

/**
 * Class User
 * @package TicTacToe\GameBundle\Domain
 */
class User extends PlayerAbstract
{
    /** @var int */
    private $nextMoveCoordinateX;

    /** @var int */
    private $nextMoveCoordinateY;

    /**
     * User constructor.
     * @param string $teamMarker
     * @param int $coordinateX
     * @param int $coordinateY
     */
    public function __construct(string $teamMarker, int $coordinateX, int $coordinateY)
    {
        parent::__construct($teamMarker);

        $this->nextMoveCoordinateX = $coordinateX;
        $this->nextMoveCoordinateY = $coordinateY;
    }

    /**
     * @param Board $board
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     * @return Board
     */
    public function move(Board $board): Board
    {
        $board->setPosition($this->nextMoveCoordinateX, $this->nextMoveCoordinateY, $this->getTeamMarker());

        return $board;
    }
}
