<?php

namespace TicTacToe\GameBundle\Domain;

/**
 * Class Player
 * @package TicTacToe\GameBundle\Domain
 */
abstract class Player
{
    /** @var string */
    protected $teamMarker;

    public function __construct($teamMarker)
    {
        $this->teamMarker = $teamMarker;
    }

    /**
     * Returns the team Marker given when is created (e.g.:"X", "O")
     *
     * @return string
     */
    public function getTeamMarker()
    {
        return $this->teamMarker;
    }

    //abstract public function setPosition($coordinateX, $coordinateY, $boardStatus);
}
