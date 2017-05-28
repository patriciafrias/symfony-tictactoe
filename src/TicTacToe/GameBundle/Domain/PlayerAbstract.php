<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Domain;

/**
 * Class PlayerAbstract
 * @package TicTacToe\GameBundle\Domain
 */
abstract class PlayerAbstract
{
    /** @var string */
    protected $teamMarker;

    /**
     * Player constructor.
     * @param string $teamMarker
     */
    public function __construct(string $teamMarker)
    {
        $this->teamMarker = $teamMarker;
    }

    /**
     * Returns the team Marker identifier ("X" || "O")
     * @return string
     */
    public function getTeamMarker(): string
    {
        return $this->teamMarker;
    }

    /**
     * Gets a board and returns a modified board.
     * @param Board $board
     * @return Board
     */
    abstract public function move(Board $board): Board;
}
