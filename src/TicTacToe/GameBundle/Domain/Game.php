<?php

namespace TicTacToe\GameBundle\Domain;

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
    const USER_TEAM_ID = 'X';

    const BOT_TEAM_ID = 'O';

    /** @var null|Board */
    private $board = null;

    /** @var null */
    private $winnerTeam = null;

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
        // First check if Winner
        $this->checkWinner();

        // Validate position for next move
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

        // Non-existent position.
        if (!isset($gameStatus[$x][$y])) {
            throw new InvalidPositionException("Position [$x,$y] does not exist.");
        } else {
            // Check if there is any available position
            $rowsWithAvailablePositions = array_filter($gameStatus, function ($position) {
                return in_array("", $position);
            });

            // If there is not empty position Board is completed.
            if (!$rowsWithAvailablePositions) {
                throw new NoPositionsAvailableException("No positions available. Game is over.");
            } else {
                // Busy position but there are available positions.
                if (!empty($gameStatus[$x][$y]) && $rowsWithAvailablePositions) {
                    throw new NotEmptyPositionException("Position [$x,$y] is not availabale.");
                }
            }
        }
    }

    /**
     * @return mixed|null
     */
    private function checkWinner()
    {
        $gameStatus = $this->getBoard()->getStatus();

        if ($this->isWinnerByRow($gameStatus)
            || $this->isWinnerByColumn($gameStatus)
            || $this->isWinnerByDiagonals($gameStatus)
        ) {
            if (!empty($this->winnerTeam)) {
                throw new FinishedGameWithWinnerException("Team {$this->winnerTeam} wins.");
            }
        }
    }

    // Check winner per ROW
    private function isWinnerByRow($gameStatus)
    {
        // TODO: maybe better move to a separated class

        for ($i = 0; $i < count($gameStatus); $i++) {
            if ("" == $gameStatus[$i][0]) {
                continue;
            }

            $teamPositions = 0;
            $teamPositionZero = $gameStatus[$i][0];

            for ($j = 0; $j < count($gameStatus); $j++) {
                if ($teamPositionZero == $gameStatus[$i][$j]) {
                    $teamPositions++;
                }
            }

            if ($teamPositions == count($gameStatus)) {
                $this->winnerTeam = $teamPositionZero;
                return true;
            }
        }

        return false;
    }

    // Check winner per COLUMN
    private function isWinnerByColumn($gameStatus)
    {
        // TODO: refactor by moving this code to a separated function/class

        for ($j = 0; $j < count($gameStatus); $j++) {
            if ("" == $gameStatus[0][$j]) {
                continue;
            }

            $teamPositions = 0;
            $teamPositionZero = $gameStatus[0][$j];

            for ($i = 0; $i < count($gameStatus); $i++) {
                if ($teamPositionZero == $gameStatus[$i][$j]) {
                    $teamPositions++;
                }
            }

            if ($teamPositions == count($gameStatus)) {
                $this->winnerTeam = $teamPositionZero;
                return true;
            }
        }

        return false;
    }

    // Check winner per DIAGONAL
    private function isWinnerByDiagonals($gameStatus)
    {
        // TODO: refactor by moving this code to a separated function/class
        return $this->isWinnerByMainDiagonal($gameStatus) || $this->isWinnerBySecondDiagonal($gameStatus);
    }

    private function isWinnerByMainDiagonal($gameStatus): bool
    {
        $teamPositions = 0;
        $teamPositionZero = $gameStatus[0][0];

        for ($i = 0; $i < count($gameStatus); $i++) {
            if ("" == $teamPositionZero) {
                break;
            }

            for ($j = 0; $j < count($gameStatus[$i]); $j++) {
                if ($i == $j) {
                    if ($teamPositionZero == $gameStatus[$i][$j]) {
                        $teamPositions++;
                    }
                }
            }
        }

        if ($teamPositions == count($gameStatus)) {
            $this->winnerTeam = $teamPositionZero;
            return true;
        }

        return false;
    }

    private function isWinnerBySecondDiagonal($gameStatus): bool
    {
        $teamPositions = 0;
        $teamPositionZero = $gameStatus[0][count($gameStatus)-1];

        for ($i = 0; $i < count($gameStatus); $i++) {
            if ("" == $teamPositionZero) {
                break;
            }

            for ($j = count($gameStatus[$i]) - 1; $j >= 0; $j--) {
                if ($i + $j == count($gameStatus) - 1) {
                    if ($teamPositionZero == $gameStatus[$i][$j]) {
                        $teamPositions++;
                    }
                }
            }
        }

        if ($teamPositions == count($gameStatus)) {
            $this->winnerTeam = $teamPositionZero;
            return true;
        }

        return false;
    }
}
