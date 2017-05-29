<?php

declare(strict_types = 1);

namespace TicTacToe\GameBundle\Tests\Unit\Domain;

use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject;
use TicTacToe\GameBundle\Domain\Board;
use TicTacToe\GameBundle\Domain\Game;
use TicTacToe\GameBundle\Domain\PlayerAbstract;

/**
 * Class GameTest
 * @package TicTacToe\GameBundle\Tests\Unit\Domain
 */
class GameTest extends TestCase
{
    /** @var PHPUnit_Framework_MockObject_MockObject|Board */
    private $boardMock = null;

    /** @var PHPUnit_Framework_MockObject_MockObject|PlayerAbstract */
    private $playerMock = null;

    public function setUp()
    {
        $this->boardMock = $this->getMockBuilder(Board::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStatus', 'setPosition', 'validatePosition'])
            ->getMock();

        $this->playerMock = $this->getMockBuilder(PlayerAbstract::class)
            ->disableOriginalConstructor()
            ->setMethods(['move'])
            ->getMock();
    }

    public function testInitializeGameShouldReturnEmptyBoard()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['', '', ''], ['', '', ''], ['', '', '']]);

        $game = new Game($this->boardMock);

        $this->assertEquals([['', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    public function testPlayerMoveShouldReturnModifiedBoardWithNewUserPosition()
    {
        $this->boardMock->expects($this->exactly(4))
            ->method('getStatus')
            ->willReturn([['X', '', ''], ['', '', ''], ['', '', '']]);

        $this->playerMock->expects($this->once())
            ->method('move')
            ->with($this->boardMock)
            ->willReturn($this->boardMock);

        $game = new Game($this->boardMock);

        $game->move($this->playerMock);

        $this->assertEquals([['X', '', ''], ['', '', ''], ['', '', '']], $game->getBoard()->getStatus());
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByRowShouldThrowException()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['X', 'X', 'X'], ['', '', ''], ['', '', '']]);

        $game = new Game($this->boardMock);

        $game->move($this->playerMock);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByColumnShouldThrowException()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['X', '', ''], ['X', '', ''], ['X', '', '']]);

        $game = new Game($this->boardMock);

        $game->move($this->playerMock);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerByMainDiagonalShouldThrowException()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['X', '', ''], ['', 'X', ''], ['', '', 'X']]);

        $game = new Game($this->boardMock);

        $game->move($this->playerMock);
    }

    /**
     * @expectedException \TicTacToe\GameBundle\Exception\FinishedGameWithWinnerException
     */
    public function testMoveUserWhenThereIsWinnerBySecondDiagonalShouldThrowException()
    {
        $this->boardMock->expects($this->once())
            ->method('getStatus')
            ->willReturn([['', '', 'X'], ['', 'X', ''], ['X', '', '']]);

        $game = new Game($this->boardMock);

        $game->move($this->playerMock);
    }
}
