<?php

namespace TicTacToe\GameBundle\Domain;

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

    public function __construct(int $boardSize)
    {
        $this->gameSize = $boardSize;

        $this->initializeBoard();
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
}
