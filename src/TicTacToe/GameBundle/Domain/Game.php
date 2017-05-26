<?php

namespace TicTacToe\GameBundle\Domain;
use PHPUnit\Runner\Exception;

/**
 * Class Game
 * @package TicTacToe\GameBundle\Domain
 */
class Game
{
    /** @var null|Board  */
    private $board = null;

    public const USER_TEAM_MARKER = 'X';

    public const BOT_TEAM_MARKER = 'O';

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
     * @param $coordinateX
     * @param $coordinateY
     * @param $player Player
     */
    public function move($coordinateX, $coordinateY, $player)
    {
        try {
            $position = $this->validatePosition($coordinateX, $coordinateY);

            if ("" == $position) {
                $updatedBoard = $player->setPosition($coordinateX, $coordinateY, $this->getBoard()->getStatus());

                $this->getBoard()->setStatus($updatedBoard);
            }
        } catch (\Exception $e) {
            echo "Error. $e->getMessage()" . PHP_EOL;
        }

        return $this->getBoard()->getStatus();
    }

    private function validatePosition($x, $y)
    {
        $position = $this->getBoard()->getStatus()[$x][$y];

        if (!isset($position)) {
            // TODO: throws an exception position doesn't exist
            throw new Exception("'Position doesn't exist.");
        }

        return $position;
    }

}
