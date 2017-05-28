<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

use TicTacToe\GameBundle\Domain\Helper\GameOverHelper;
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
        $gameStatus = $board->getStatus();

        $coordinateX = 0;
        $coordinateY = 0;

        $bestValue = -1000;

        for ($i = 0; $i < count($gameStatus); $i++) {
            for ($j = 0; $j < count($gameStatus[$i]); $j++) {
                if (empty($gameStatus[$i][$j])) {
                    // make the move
                    $gameStatus[$i][$j] = $this->teamMarker;
                    // compute evaluation function for this move.
                    $moveValue = $this->minimax($gameStatus, 0, false);
                    // undo the move
                    $gameStatus[$i][$j] = '';
                    // if the value of the current move is bigger than the bestValue update bestValue
                    if ($moveValue > $bestValue) {
                        $bestValue = $moveValue;
                        $coordinateX = $i;
                        $coordinateY = $j;
                    }
                }
            }
        }

        $this->nextMoveCoordinateX = $coordinateX;
        $this->nextMoveCoordinateY = $coordinateY;
    }

    /**
     * @param array $gameStatus
     * @param int $level
     * @param bool $isBotTeam
     * @return int
     */
    private function minimax(array $gameStatus, int $level, bool $isBotTeam): int
    {
        // if there is a winner returns min or max score
        $winner = GameOverHelper::getWinner($gameStatus);
        if (!empty($winner)) {
            return ($winner === Game::BOT_TEAM_ID ? 10 : -10);
        }
        // if not moves left returns draw
        if (GameOverHelper::isGameOver($gameStatus)) {
            return 0;
        }
        // my team
        if ($isBotTeam) {
            $bestMove = -1000;
            for ($i = 0; $i < count($gameStatus); $i++) {
                for ($j = 0; $j < count($gameStatus[$i]); $j++) {
                    if (empty($gameStatus[$i][$j])) {
                        // make the move
                        $gameStatus[$i][$j] = Game::BOT_TEAM_ID;
                        // call minimax recursively and choose the maximum value
                        $bestMove = max($bestMove, $this->minimax($gameStatus, $level + 1, !$isBotTeam));
                        // undo the move
                        $gameStatus[$i][$j] = '';
                    }
                }
            }
            return $bestMove;
        } else { // opponent team
            $bestMove = 1000;
            for ($i = 0; $i < count($gameStatus); $i++) {
                for ($j = 0; $j < count($gameStatus[$i]); $j++) {
                    if (empty($gameStatus[$i][$j])) {
                        // make the move
                        $gameStatus[$i][$j] = Game::USER_TEAM_ID;
                        // call minimax recursively and choose the minimum value
                        $bestMove = min($bestMove, $this->minimax($gameStatus, $level + 1, !$isBotTeam));
                        // undo the move
                        $gameStatus[$i][$j] = '';
                    }
                }
            }
            return $bestMove;
        }
    }
}
