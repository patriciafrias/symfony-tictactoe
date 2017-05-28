<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use TicTacToe\GameBundle\Domain\Board;

class BoardTest extends TestCase
{
    public function testGetStatusShouldReturnEmptyStatusArray()
    {
        $board = new Board(3);

        $this->assertEquals([['','',''],['','',''],['','','']], $board->getStatus());
    }

    public function testSetStatusShouldModifyStatusArray()
    {
        $board = new Board(3);
        $board->setStatus([['X','X','X'],['X','X','X'],['X','X','X']]);

        $this->assertEquals([['X','X','X'],['X','X','X'],['X','X','X']], $board->getStatus());
    }

    public function testSetPositionForValidPositionShouldModifyBoardStatus()
    {
        $board = new Board(3);

        $board->setPosition(0, 0, 'X');

        $this->assertEquals([['X','',''],['','',''],['','','']], $board->getStatus());
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\InvalidPositionException
     */
    public function testSetPositionForInvalidPositionShouldThrowException()
    {
        $board = new Board(3);

        $board->setPosition(99, 99, 'X');
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NoPositionsAvailableException
     */
    public function testSetPositionForFullBoardShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X','X','X'],['X','X','X'],['X','X','X']]);

        $board->setPosition(0, 0, 'X');
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\NotEmptyPositionException
     */
    public function testSetPositionForNotEmptyPositionShouldThrowException()
    {
        $board = new Board(3);
        $board->setStatus([['X','X','X'],['','',''],['','','']]);

        $board->setPosition(0, 0, 'X');
    }
}
