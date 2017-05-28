<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Domain\Helper\GameOverHelper;
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
        if (!isset($this->status[$coordinateX][$coordinateY])) {
            throw new InvalidPositionException("Position [$coordinateX,$coordinateY] does not exist.");
        } else {
            $gameOver = GameOverHelper::isGameOver($this->status);

            if ($gameOver) {
                throw new NoPositionsAvailableException("No positions available. Game is over.");
            } else {
                if (!empty($this->status[$coordinateX][$coordinateY]) && !$gameOver) {
                    throw new NotEmptyPositionException("Position [$coordinateX,$coordinateY] is not availabale.");
                }
            }
        }
    }
}
