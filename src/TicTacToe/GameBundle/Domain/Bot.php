<?php

namespace TicTacToe\GameBundle\Domain;

/**
 * Class Bot
 * @package TicTacToe\GameBundle\Domain
 */
class Bot extends Player
{
    public function setPosition($coordinateX, $coordinateY, $boardStatus)
    {
        $boardStatus[$coordinateX][$coordinateY] = $this->getTeamMarker();

        return $boardStatus;
    }
}
