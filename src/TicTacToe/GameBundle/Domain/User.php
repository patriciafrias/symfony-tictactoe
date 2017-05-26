<?php

namespace TicTacToe\GameBundle\Domain;

/**
 * Class User
 * @package TicTacToe\GameBundle\Domain
 */
class User extends Player
{
    public function setPosition($coordinateX, $coordinateY, $boardStatus)
    {
        $boardStatus[$coordinateX][$coordinateY] = $this->getTeamMarker();

        return $boardStatus;
    }
}
