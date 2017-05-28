<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain\Helper;

/**
 * Class GameOverHelper.
 *
 * Checks if there is a winner or game is over.
 *
 * @package TicTacToe\GameBundle\Domain\Helper
 */
class GameOverHelper
{
    /** @var null */
    private static $winnerTeam = null;

    /**
     * @param array $gameStatus
     * @return string
     */
    public static function getWinner(array $gameStatus)
    {
        if (self::isWinnerByRow($gameStatus)
            || self::isWinnerByColumn($gameStatus)
            || self::isWinnerByDiagonals($gameStatus)
        ) {
            return self::$winnerTeam;
        } else {
            return '';
        }
    }

    /**
     * Check if there is any available position.
     * @param array $gameStatus
     * @return bool
     */
    public static function isGameOver(array $gameStatus)
    {
        $rowsWithAvailablePositions = array_filter($gameStatus, function ($position) {
            return in_array("", $position);
        });

        return !$rowsWithAvailablePositions;
    }

    /**
     * @param $gameStatus
     * @return bool
     */
    private static function isWinnerByRow(array $gameStatus)
    {
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
                self::$winnerTeam = $teamPositionZero;
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $gameStatus
     * @return bool
     */
    private static function isWinnerByColumn(array $gameStatus)
    {
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
                self::$winnerTeam = $teamPositionZero;
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $gameStatus
     * @return bool
     */
    private static function isWinnerByDiagonals(array $gameStatus)
    {
        return self::isWinnerByMainDiagonal($gameStatus) || self::isWinnerBySecondDiagonal($gameStatus);
    }

    /**
     * @param array $gameStatus
     * @return bool
     */
    private static function isWinnerByMainDiagonal(array $gameStatus): bool
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
            self::$winnerTeam = $teamPositionZero;
            return true;
        }

        return false;
    }

    /**
     * @param array $gameStatus
     * @return bool
     */
    private static function isWinnerBySecondDiagonal(array $gameStatus): bool
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
            self::$winnerTeam = $teamPositionZero;
            return true;
        }

        return false;
    }
}
