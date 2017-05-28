<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Exception\InvalidPositionException;
use TicTacToe\GameBundle\Exception\NoPositionsAvailableException;
use TicTacToe\GameBundle\Exception\NotEmptyPositionException;

/**
 * Class Board
 * @package TicTacToe\GameBundle\Domain
 */
class Board
{
    /** @var int */
    private $gameSize = 0;

    /** @var array */
    private $status = [];

    /**
     * Board constructor.
     * @param int $boardSize
     */
    public function __construct(int $boardSize)
    {
        $this->gameSize = $boardSize;

        $this->initializeBoard();
    }

    /**
     * @param int $coordinateX
     * @param int $coordinateY
     * @param string $teamMarker
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     */
    public function setPosition(int $coordinateX, int $coordinateY, string $teamMarker)
    {
        $this->validatePosition($coordinateX, $coordinateY);

        $this->status[$coordinateX][$coordinateY] = $teamMarker;
    }

    /**
     * @return array
     */
    public function getStatus(): array
    {
        return $this->status;
    }

    /**
     * @param array $status
     * @return Board
     */
    public function setStatus(array $status): Board
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Build a new board with a given size.
     */
    private function initializeBoard()
    {
        for ($i=0; $i<$this->gameSize; $i++) {
            $this->status[] = [];
            for ($j=0; $j<$this->gameSize; $j++) {
                $this->status[$i][$j] = '';
            }
        }
    }

    /**
     * @param int $coordinateX
     * @param int $coordinateY
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     */
    private function validatePosition(int $coordinateX, int $coordinateY)
    {
        // Non-existent position.
        if (!isset($this->status[$coordinateX][$coordinateY])) {
            throw new InvalidPositionException("Position [$coordinateX,$coordinateY] does not exist.");
        } else {
            // Check if there is any available position.
            $rowsWithAvailablePositions = array_filter($this->status, function ($position) {
                return in_array("", $position);
            });

            // If there is not empty position Board is completed.
            if (!$rowsWithAvailablePositions) {
                throw new NoPositionsAvailableException("No positions available. Game is over.");
            } else {
                // Busy position but there are available positions.
                if (!empty($this->status[$coordinateX][$coordinateY]) && $rowsWithAvailablePositions) {
                    throw new NotEmptyPositionException("Position [$coordinateX,$coordinateY] is not availabale.");
                }
            }
        }
    }
}
