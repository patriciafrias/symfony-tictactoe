<?php

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Exception\InvalidPositionException;
use TicTacToe\GameBundle\Exception\NoPositionsAvailableException;
use TicTacToe\GameBundle\Exception\NotEmptyPositionException;

/**
 * Class Game
 * @package TicTacToe\GameBundle\Domain
 */
class Game
{
    /** @var null|Board */
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
     * @param Player $player
     * @param int $coordinateX
     * @param int $coordinateY
     * @return array
     */
    public function move(Player $player, int $coordinateX, int $coordinateY)
    {
        $this->validatePosition($coordinateX, $coordinateY);

        $this->getBoard()->setPosition($coordinateX, $coordinateY, $player->getTeamMarker());

        return $this->getBoard()->getStatus();
    }

    /**
     * @param int $x
     * @param int $y
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     */
    private function validatePosition(int $x, int $y)
    {
        $gameStatus = $this->getBoard()->getStatus();

        // Check if there is any available position
        $rowsWithAvailablePositions = array_filter($gameStatus, function ($position) {
            return in_array("", $position);
        });

        // Non-existent position.
        if (!isset($gameStatus[$x][$y])) {
            throw new InvalidPositionException("Error. Position [$x,$y] does not exist.");

        } else {

            // If there is not empty position Board is completed.
            if (!$rowsWithAvailablePositions) {
                throw new NoPositionsAvailableException("Error. No positions available. Game is over.");

            } else {

                // Busy position but there are available positions.
                if (!empty($gameStatus[$x][$y]) && $rowsWithAvailablePositions) {
                    throw new NotEmptyPositionException("Error. Position [$x,$y] is not availabale.");
                }
            }
        }
    }
}
