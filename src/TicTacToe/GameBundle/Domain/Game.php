<?php

declare(strict_types = 1);

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
    /** @var string */
    const USER_TEAM_ID = 'X';

    /** @var string */
    const BOT_TEAM_ID = 'O';

    /** @var null|Board */
    private $board = null;

    /** @var null */
    private $winnerTeam = null;

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
     * @param PlayerAbstract $player
     * @throws InvalidPositionException
     * @throws NoPositionsAvailableException
     * @throws NotEmptyPositionException
     * @return array
     */
    public function move(PlayerAbstract $player)
    {
        $this->checkWinner();

        $this->board = $player->move($this->getBoard());

        return $this->getBoard()->getStatus();
    }

    /**
     * @throws FinishedGameWithWinnerException
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

    /**
     * @param $gameStatus
     * @return bool
     */
    private function isWinnerByRow(array $gameStatus)
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

    /**
     * @param array $gameStatus
     * @return bool
     */
    private function isWinnerByColumn(array $gameStatus)
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

    /**
     * @param array $gameStatus
     * @return bool
     */
    private function isWinnerByDiagonals(array $gameStatus)
    {
        // TODO: refactor by moving this code to a separated function/class
        return $this->isWinnerByMainDiagonal($gameStatus) || $this->isWinnerBySecondDiagonal($gameStatus);
    }

    private function isWinnerByMainDiagonal(array $gameStatus): bool
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

    /**
     * @param array $gameStatus
     * @return bool
     */
    private function isWinnerBySecondDiagonal(array $gameStatus): bool
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
